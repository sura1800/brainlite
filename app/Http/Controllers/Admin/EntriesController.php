<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyEntry;
use App\Models\Batch;
use App\Models\Sector;
use App\Models\Tcid;
use App\Models\JobRole;
use App\Models\Customer;

class EntriesController extends Controller
{
    public function index(Request $request){
        $data['batches']   = Batch::whereNull('deleted_at')->where('status','Y')->orderBy('batch_id','desc')->get();
        $data['sectors']   = Sector::whereNull('deleted_at')->where('status','Y')->orderBy('sector_id','desc')->get();
        $data['job_roles'] = JobRole::whereNull('deleted_at')->where('status','Y')->orderBy('job_role_id','desc')->get();
        $data['tcids']     = Tcid::whereNull('deleted_at')->where('status','Y')->orderBy('tcid_id','desc')->get();
        $data['customers']  = Customer::get();

        $entries = DailyEntry::join('batches','daily_entries.batch_id','batches.batch_id')
                ->join('sectors','daily_entries.sector_id','sectors.sector_id')
                ->join('tcids','daily_entries.tcid_id','tcids.tcid_id')
                ->join('job_roles','daily_entries.job_role_id','job_roles.job_role_id')
                ->join('customers','daily_entries.user_id','customers.id')
                ->select('daily_entries.*','batches.batch_name','sectors.sector_name','tcids.tcid','job_roles.job_role_name','customers.name');

                if(isset($_GET['user_id']) && !empty($_GET['user_id'])){
                    $entries = $entries->where('daily_entries.user_id',$_GET['user_id']);
                }
                if(isset($_GET['batch_id']) && !empty($_GET['batch_id'])){
                    $entries = $entries->where('daily_entries.batch_id',$_GET['batch_id']);
                }
                if(isset($_GET['tcid_id']) && !empty($_GET['tcid_id'])){
                    $entries = $entries->where('daily_entries.tcid_id',$_GET['tcid_id']);
                }
                if(isset($_GET['job_role_id']) && !empty($_GET['job_role_id'])){
                    $entries = $entries->where('daily_entries.job_role_id',$_GET['job_role_id']);
                }
                if(isset($_GET['sector_id']) && !empty($_GET['sector_id'])){
                    $entries = $entries->where('daily_entries.sector_id',$_GET['sector_id']);
                }
                if(isset($_GET['entry_date']) && !empty($_GET['entry_date'])){
                    $entries = $entries->whereDate('daily_entries.entry_date',$_GET['entry_date']);
                }

        $data['entries'] = $entries->whereNull('daily_entries.deleted_at')
                           ->orderBy('daily_entries.daily_entry_id','desc')->paginate(10);
        return view('admin.dailyentry.index',$data);
    }

    public function show(DailyEntry $daily_entry)
    {
        $data['customers']  = Customer::get();
        $data['batches']   = Batch::whereNull('deleted_at')->where('status','Y')->orderBy('batch_id','desc')->get();
        $data['sectors']   = Sector::whereNull('deleted_at')->where('status','Y')->orderBy('sector_id','desc')->get();
        $data['job_roles'] = JobRole::whereNull('deleted_at')->where('status','Y')->orderBy('job_role_id','desc')->get();
        $data['tcids']     = Tcid::whereNull('deleted_at')->where('status','Y')->orderBy('tcid_id','desc')->get();
        $data['entry_details']  = DailyEntry::where('daily_entry_id', "=", $daily_entry->daily_entry_id)->first();
        return view('admin.dailyentry.show', $data);
    }
}
