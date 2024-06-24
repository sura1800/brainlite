<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Sector;
use App\Models\Student;
use App\Models\Tcid;
use App\Models\JobRole;
use App\Models\DailyEntry;
use App\Models\Customer;

class DashboardController extends Controller
{

    public function dashboard(Request $request){
        $data['students']  = Student::whereNull('deleted_at')->count();
        $data['batches']   = Batch::whereNull('deleted_at')->count();
        $data['sectors']   = Sector::whereNull('deleted_at')->count();
        $data['job_roles'] = JobRole::whereNull('deleted_at')->count();
        $data['tcids']     = Tcid::whereNull('deleted_at')->count();
        $data['users']     = Customer::count();
        $data['entries']   = DailyEntry::whereNull('deleted_at')->count();

        return view('admin.dashboard',$data);
    }
}
