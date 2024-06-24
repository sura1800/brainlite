<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tcid;

class TcIdController extends Controller
{
    public function index(Request $request){
        $data['tcids'] = Tcid::whereNull('deleted_at')->orderBy('tcid_id','desc')->get();
        return view('admin.tcid.index',$data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'tcid'  => 'required|string|unique:tcids,tcid',
            'status' => 'required|In:N,Y',
        ]);
        $inserted = Tcid::create($validated);
        if($inserted){
            return redirect()->back()->with('message','TC ID Create Successfully.');
        }
        else{
            return redirect()->back()->withErrors(['message' => 'Error While Creating TC ID.'])->withInput();
        }
    }

    public function update(Request $request){
         $request->validate([
            'tcid_id'  => 'required|integer',
            'tcid'  => 'required|string|unique:tcids,tcid,'.$request->tcid_id.',tcid_id',
            'status'      => 'required|In:N,Y',
        ]);
        $update = Tcid::find($request->tcid_id);
        $update->tcid = $request->tcid;
        $update->status = $request->status;
        if($update->save()){
            return redirect()->back()->with('message','TC ID Updated Successfully.');
        }
        else{
            return redirect()->back()->withErrors(['message' => 'IC ID Updated Unsuccessfully.'])->withInput();
        }
    }
}
