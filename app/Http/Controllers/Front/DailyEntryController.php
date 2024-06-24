<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyEntry;
use App\Models\Batch;
use App\Models\Sector;
use App\Models\Tcid;
use App\Models\JobRole;
use Illuminate\Support\Facades\Auth;

class DailyEntryController extends Controller
{
    public function index(Request $request){
        $user_id = Auth::guard('front')->user()->id;
        $data['batches']   = Batch::whereNull('deleted_at')->where('status','Y')->orderBy('batch_id','desc')->get();
        $data['sectors']   = Sector::whereNull('deleted_at')->where('status','Y')->orderBy('sector_id','desc')->get();
        $data['job_roles'] = JobRole::whereNull('deleted_at')->where('status','Y')->orderBy('job_role_id','desc')->get();
        $data['tcids']     = Tcid::whereNull('deleted_at')->where('status','Y')->orderBy('tcid_id','desc')->get();

        $entries = DailyEntry::join('batches','daily_entries.batch_id','batches.batch_id')
                ->join('sectors','daily_entries.sector_id','sectors.sector_id')
                ->join('tcids','daily_entries.tcid_id','tcids.tcid_id')
                ->join('job_roles','daily_entries.job_role_id','job_roles.job_role_id')
                ->select('daily_entries.*','batches.batch_name','sectors.sector_name','tcids.tcid','job_roles.job_role_name');

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

        $data['entries'] = $entries->where('daily_entries.user_id',$user_id)->whereNull('daily_entries.deleted_at')
                           ->orderBy('daily_entries.daily_entry_id','desc')->paginate(10);
        return view('front.dailyentry.index',$data);
    }

    public function create(Request $request){
        $data['batches']   = Batch::whereNull('deleted_at')->where('status','Y')->orderBy('batch_id','desc')->get();
        $data['sectors']   = Sector::whereNull('deleted_at')->where('status','Y')->orderBy('sector_id','desc')->get();
        $data['job_roles'] = JobRole::whereNull('deleted_at')->where('status','Y')->orderBy('job_role_id','desc')->get();
        $data['tcids']     = Tcid::whereNull('deleted_at')->where('status','Y')->orderBy('tcid_id','desc')->get();
        return view('front.dailyentry.add',$data);
    }

    public function store(Request $request){

        $validated = $request->validate([
            'user_id'     => 'required|integer',
            'entry_date'  => 'required|date',
            'batch_id'    => 'required|integer',
            'tcid_id'     => 'required|integer',
            'images'      => 'required|array|size:2',
            'images.*'    => 'image|mimes:jpg,jpeg,png|min:1|max:5000',
            'job_role_id' => 'required|integer',
            'sector_id'   => 'required|integer',
        ]);

        foreach($request->file('images') as $image) {
            $str_image[] = $image->hashName();
            $location = public_path('/upload/daily_entry/');
            $image->move($location, $image->hashName());
        }
        $final_image = json_encode($str_image);
        $inserted = new DailyEntry;
        $inserted->user_id = $request->user_id;
        $inserted->entry_date = $request->entry_date;
        $inserted->batch_id = $request->batch_id;
        $inserted->tcid_id = $request->tcid_id;
        $inserted->job_role_id = $request->job_role_id;
        $inserted->sector_id = $request->sector_id;
        $inserted->images = $final_image;
        if ($inserted->save()){
            return redirect()->route('daily-entries.index')->with(['message' => 'Data Added Successfully.','class' => 'success']);
        } else {
            return redirect()->back()->withErrors(['message' => 'Error While Creating Data.'])->withInput();
        }
    }

    public function destroy(DailyEntry $daily_entry)
    {
        $del = DailyEntry::find($daily_entry->daily_entry_id);
        $del->delete();
        return redirect()->back()->withSuccess('Data Deleted Successfully.');
    }

    public function show(DailyEntry $daily_entry)
    {
        $data['batches']   = Batch::whereNull('deleted_at')->where('status','Y')->orderBy('batch_id','desc')->get();
        $data['sectors']   = Sector::whereNull('deleted_at')->where('status','Y')->orderBy('sector_id','desc')->get();
        $data['job_roles'] = JobRole::whereNull('deleted_at')->where('status','Y')->orderBy('job_role_id','desc')->get();
        $data['tcids']     = Tcid::whereNull('deleted_at')->where('status','Y')->orderBy('tcid_id','desc')->get();
        $data['entry_details']  = DailyEntry::where('daily_entry_id', "=", $daily_entry->daily_entry_id)->first();
        return view('front.dailyentry.show', $data);
    }
}
