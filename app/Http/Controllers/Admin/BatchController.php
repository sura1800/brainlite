<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;

class BatchController extends Controller
{

    public function index(Request $request){
        $data['batches'] = Batch::whereNull('deleted_at')->orderBy('batch_id','desc')->get();
        return view('admin.batch.index',$data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'batch_name'  => 'required|string|unique:batches,batch_name',
            'status'      => 'required|In:N,Y',
        ]);
        $inserted = Batch::create($validated);
        if($inserted){
            return redirect()->back()->with('message','Batch Created Successfully.');
        }
        else{
            return redirect()->back()->withErrors(['message' => 'Error While Creating Batch.'])->withInput();
        }
    }

    public function update(Request $request){
         $request->validate([
            'batch_id'  => 'required|integer',
            'batch_name'  => 'required|string|unique:batches,batch_name,'.$request->batch_id.',batch_id',
            'status'      => 'required|In:N,Y',
        ]);
        $update = Batch::find($request->batch_id);
        $update->batch_name = $request->batch_name;
        $update->status = $request->status;
        if($update->save()){
            return redirect()->back()->with('message','Batch Updated Successfully.');
        }
        else{
            return redirect()->back()->withErrors(['message' => 'Batch Updated Unsuccessfully.'])->withInput();
        }
    }
}
