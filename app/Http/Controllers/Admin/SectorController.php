<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sector;

class SectorController extends Controller
{
    public function index(Request $request){
        $data['sectors'] = Sector::whereNull('deleted_at')->orderBy('sector_id','desc')->get();
        return view('admin.sector.index',$data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'sector_name'    => 'required|string|unique:sectors,sector_name',
            'status'         => 'required|In:N,Y',
        ]);
        $inserted = Sector::create($validated);
        if($inserted){
            return redirect()->back()->with('message','Sector Created Successfully.');
        }
        else{
            return redirect()->back()->withErrors(['message' => 'Error While Creating Sector.'])->withInput();
        }
    }

    public function update(Request $request){
         $request->validate([
            'sector_id'    => 'required|integer',
            'sector_name'  => 'required|string|unique:sectors,sector_name,'.$request->sector_id.',sector_id',
            'status'       => 'required|In:N,Y',
        ]);
        $update = Sector::find($request->sector_id);
        $update->sector_name = $request->sector_name;
        $update->status = $request->status;
        if($update->save()){
            return redirect()->back()->with('message','Sector Updated Successfully.');
        }
        else{
            return redirect()->back()->withErrors(['message' => 'Sector Updated Unsuccessfully.'])->withInput();
        }
    }
}
