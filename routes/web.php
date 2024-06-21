<?php

use App\Http\Controllers\Admin\AjaxController;

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\LedgerDocController;
use App\Http\Controllers\Admin\LegalDocController;
use App\Http\Controllers\Front\CustomerProfileController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\StudentController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Front\FrontPageController;
use App\Http\Controllers\Front\FrontStudentController;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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
            return view('front.dashboard');
        })->name('dashboard');

    Route::get('/profile', [CustomerProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [CustomerProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get("/students", [FrontStudentController::class, 'index'])->name('students');
    Route::get("/students/show/{id}", [FrontStudentController::class, 'show']);
    Route::post("/students/create", [FrontStudentController::class, 'store']);
    Route::get("/students/export/{token}", [FrontStudentController::class, 'studentExport']);
});

require __DIR__ . '/customer_auth.php';

// Admin Routes
require __DIR__ . '/admin_auth.php';
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('admin.dashboard');
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

    Route::resource('legaldocs', 'LegalDocController');
    Route::get('legaldocs-import', [LegalDocController::class, 'importLegalDoc'])->name('legaldocs_import');
    Route::post('legaldocs-import', [LegalDocController::class, 'importLegalDocSubmit'])->name('legaldocs_import.store');

    Route::get('legaldocs-file-upload', [LegalDocController::class, 'fileUploadLegalDoc'])->name('legaldocs_fileupload');
    Route::post('legaldocs-file-upload', [LegalDocController::class, 'fileUploadLegalDocSubmit'])->name('legaldocs_fileupload.store');
    Route::get('view-legaldocs-file/{legaldoc}', [LegalDocController::class, 'viewFile'])->name('view_legaldocs_file');
    Route::post('/customer-files', [AjaxController::class, 'getCustomerLegalDocs'])->name('customer_legal_docs');


    Route::resource('ledgerdocs', 'LedgerDocController');

    Route::get('ledgerdocs-import', [LedgerDocController::class, 'importLedgerDoc'])->name('ledgerdocs_import');
    Route::post('ledgerdocs-import', [LedgerDocController::class, 'importLedgerDocSubmit'])->name('ledgerdocs_import.store');
    Route::get('ledgerdocs-file-upload', [LedgerDocController::class, 'fileUploadLedgerDoc'])->name('ledgerdocs_fileupload');
    Route::post('ledgerdocs-file-upload', [LedgerDocController::class, 'fileUploadLedgerDocSubmit'])->name('ledgerdocs_fileupload.store');
    Route::get('view-ledgerdocs-file/{ledgerdoc}', [LedgerDocController::class, 'viewFile'])->name('view_ledgerdocs_file');



    Route::resource('frontusers', 'CustomerController');
    Route::resource('students', 'StudentController');
    Route::get('student-export/{token}', [StudentController::class, 'studentExport']);

});
