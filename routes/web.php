<?php

use App\Http\Controllers\Admin\AjaxController;

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\LedgerDocController;
use App\Http\Controllers\Admin\LegalDocController;
use App\Http\Controllers\Front\CustomerProfileController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\TcIdController;
use App\Http\Controllers\Admin\JobRoleController;
use App\Http\Controllers\Admin\SectorController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Front\FrontPageController;
use App\Http\Controllers\Front\FrontStudentController;
use App\Http\Controllers\Front\DailyEntryController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use App\Models\Student;
use App\Models\DailyEntry;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/phpinfo', function () {
    phpinfo();
});

Route::middleware(['front'])->group(function () {
    Route::get('/', function () {
            $data['student'] = Student::whereNull('deleted_at')->count();
            $data['entries'] = DailyEntry::where('daily_entries.user_id',Auth::guard('front')->user()->id)->whereNull('deleted_at')->count();
            return view('front.dashboard',$data);
        })->name('dashboard');

    Route::get('/profile', [CustomerProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [CustomerProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get("/students", [FrontStudentController::class, 'index'])->name('students');
    Route::get("/students/show/{id}", [FrontStudentController::class, 'show']);
    Route::post("/students/create", [FrontStudentController::class, 'store']);
    Route::get("/students/export/{token}", [FrontStudentController::class, 'studentExport']);

    Route::namespace('App\Http\Controllers\Front')->group(function () {
        Route::resource('daily-entries', 'DailyEntryController');
    });

});


require __DIR__ . '/customer_auth.php';

// Admin Routes
require __DIR__ . '/admin_auth.php';
Route::get('/admin/dashboard', [DashboardController::class,'dashboard'])->middleware(['auth'])->name('admin.dashboard');
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/user-status-change', [UserController::class, 'userStatusChange'])->name('user.change.status');
});

Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('users', 'UserController');

    Route::post('/common-status-change', [AjaxController::class, 'statusChange'])->name('status_change');

    Route::resource('frontusers', 'CustomerController');

    Route::resource('students', 'StudentController');
    Route::get('student-export/{token}', [StudentController::class, 'studentExport']);

    Route::resource('batches', 'BatchController');
    Route::post('batches/update', [BatchController::class, 'update']);

    Route::resource('tc_ids', 'TcIdController');
    Route::post('tc_ids/update', [TcIdController::class, 'update']);

    Route::resource('job-roles', 'JobRoleController');
    Route::post('job-roles/update', [JobRoleController::class, 'update']);

    Route::resource('sectors', 'SectorController');
    Route::post('sectors/update', [SectorController::class, 'update']);

    Route::resource('daily-entries', 'EntriesController');

});
