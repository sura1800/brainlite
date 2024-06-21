<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $notifications = PushNotification::where(['notif_type' => 1])->orWhere(['sent_status' => 1])->orderBy('future_time', 'DESC')->get();
            if ($notifications && $notifications->count() > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Data fetched successfully',
                    'data' => $notifications->toArray()
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Data not found',
                    'data' => []
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Internal Server error",
                'errors' => ['general' => $th->getMessage()]
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->post(), [
                'device_token' => ['required', 'string'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->getMessageBag()->toArray();
                return response()->json([
                    'status' => false,
                    'message' => "Invalid Data",
                    'errors' => $errors
                ], 400);
            }

            if (!Device::where(['device_token' => $validator->validated()['device_token']])->exists()) {
                Device::create($validator->validated());
            }

            return response()->json([
                'status' => true,
                'message' => 'Data stored successfully',

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Internal Server error",
                'errors' => ['general' => $th->getMessage()]
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show(Device $device)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        //
    }
}
