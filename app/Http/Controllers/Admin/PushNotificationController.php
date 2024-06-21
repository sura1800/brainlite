<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\PushNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = PushNotification::get();
        return view('admin.notification.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.notification.add');
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
            $validated =  $request->validate([
                'title' => 'required|string|max:250',
                'msg' => 'required|string',
                'notif_type' => 'required|gt:0',
                'future_time' => 'required_if:notif_type,==,2'
            ]);

            if ($validated['notif_type'] == 1) {
                $validated['future_time'] = Carbon::now();
            }

            PushNotification::create($validated);

            if ($validated['notif_type'] == 1) {
                $url = 'https://fcm.googleapis.com/fcm/send';
                $FcmToken = Device::whereNotNull('device_token')->pluck('device_token')->all();

                $serverKey = 'AAAAlPrrjKw:APA91bEHehYYUqyR0nVJd_ZigsGsMC6ftAZ4hWcbVy0xhCWS27kFY1ProlcyehbPJOJcI3iee3KfT2FxPoKWrR3nHWIeo-bXEz6O6Gp-YW1p4dzeGB9PcjSQMTSkEMJcMpQuUP_HG32-';

                $data = [
                    "registration_ids" => $FcmToken,
                    "notification" => [
                        "title" => $request->title,
                        "body" => $request->msg,
                    ]
                ];
                $encodedData = json_encode($data);

                $headers = [
                    'Authorization:key=' . $serverKey,
                    'Content-Type: application/json',
                ];

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                // Disabling SSL Certificate support temporarly
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
                // Execute post
                $result = curl_exec($ch);
                if ($result === FALSE) {
                    die('Curl failed: ' . curl_error($ch));
                }
                // Close connection
                curl_close($ch);
                // FCM response
                // dd($result);
            }


            return redirect()->back()->withSuccess('PushNotification added !!!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PushNotification  $pushNotification
     * @return \Illuminate\Http\Response
     */
    public function show(PushNotification $pushNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PushNotification  $pushNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(PushNotification $pushNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PushNotification  $pushNotification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PushNotification $pushNotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PushNotification  $pushNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(PushNotification $pushnotification)
    {
        $pushnotification->delete();
        return redirect()->back()->withSuccess('Push Notification deleted !!!');
    }
}
