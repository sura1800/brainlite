<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobRole;

class JobRoleController extends Controller
{
    public function index(Request $request){
        $data['roles'] = JobRole::whereNull('deleted_at')->orderBy('job_role_id','desc')->get();
        return view('admin.jobrole.index',$data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'job_role_name'  => 'required|string|unique:job_roles,job_role_name',
            'job_code'       => 'required|string',
            'status'         => 'required|In:N,Y',
        ]);
        $inserted = JobRole::create($validated);
        if($inserted){
            return redirect()->back()->with('message','Job Role Created Successfully.');
        }
        else{
            return redirect()->back()->withErrors(['message' => 'Error While Creating Job Role.'])->withInput();
        }
    }

    public function update(Request $request){
         $request->validate([
            'job_role_id'    => 'required|integer',
            'job_role_name'  => 'required|string|unique:job_roles,job_role_name,'.$request->job_role_id.',job_role_id',
            'job_code'       => 'required|string',
            'status'         => 'required|In:N,Y',
        ]);
        $update = JobRole::find($request->job_role_id);
        $update->job_role_name = $request->job_role_name;
        $update->job_code = $request->job_code;
        $update->status = $request->status;
        if($update->save()){
            return redirect()->back()->with('message','Job Role Updated Successfully.');
        }
        else{
            return redirect()->back()->withErrors(['message' => 'Job Role Updated Unsuccessfully.'])->withInput();
        }
    }
}
