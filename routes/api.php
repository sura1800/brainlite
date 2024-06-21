<?php

use App\Http\Controllers\Api\ApiDelegateController;
use App\Http\Controllers\Api\ApiDeviceController;
use App\Http\Controllers\Api\ApiExhibitorController;
use App\Http\Controllers\Api\ApiPageController;
// use App\Http\Controllers\Api\ApiDiseaseController;
use App\Http\Controllers\Api\ApiProgrammeController;
use App\Http\Controllers\Api\ApiSliderController;
use App\Http\Controllers\Api\ApiSpeakerController;
use App\Http\Controllers\Api\ApiSponsorController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Front\FrontPageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::post('register', [ApiUserController::class, 'register']);
// Route::post('login', [ApiUserController::class, 'login']);
// Route::post('forgot-password', [ApiUserController::class, 'forgotPassword']);

Route::get('pages', [ApiPageController::class, 'index']);
Route::post('page-details', [ApiPageController::class, 'pageDetails']);
// Route::post('about-us', [ApiDiseaseController::class, 'aboutPage']);
// Route::post('search-disease', [ApiDiseaseController::class, 'searchDisease']);

Route::get('programmes', [ApiProgrammeController::class, 'index']);
Route::get('delegates', [ApiDelegateController::class, 'index']);
Route::get('sponsors', [ApiSponsorController::class, 'index']);
Route::get('exhibitors', [ApiExhibitorController::class, 'index']);
Route::get('speakers', [ApiSpeakerController::class, 'index']);
Route::get('sliders', [ApiSliderController::class, 'index']);

Route::post('add-device', [ApiDeviceController::class, 'store']);
Route::get('get-all-notifications', [ApiDeviceController::class, 'index']);


// Route::middleware(['custom:sanctum'])->group(function () {       

// });

Route::get('api_error', function () {
    return response()->json([
        'status' => false,
        'message' => "Unauthenticated",
        'errors'=> ['general'=>"Unauthenticated"]
    ], 401);
})->name('api.error');
