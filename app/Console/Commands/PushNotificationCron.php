<?php

namespace App\Console\Commands;

use App\Models\Device;
use App\Models\PushNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PushNotificationCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pushnotification:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("Push Notification: Cron is working !");

        $notifications = PushNotification::where(['notif_type' => 2, 'sent_status' => 0])->where('future_time', '<=', Carbon::now())->get();

        if ($notifications->count() > 0) {

            $FcmToken = Device::whereNotNull('device_token')->pluck('device_token')->all();

            $url = 'https://fcm.googleapis.com/fcm/send';


            $serverKey = '';

            foreach ($notifications as  $notification) {
                $data = [
                    "registration_ids" => $FcmToken,
                    "notification" => [
                        "title" => $notification->title,
                        "body" => $notification->msg,
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
                    Log::info("Push Notification: Curl failed:". curl_error($ch));
                    // die('Curl failed: ' . curl_error($ch));
                }else{
                    PushNotification::where('id', $notification->id)->update(['sent_status'=>1]);
                }
                // Close connection
                curl_close($ch);
            }
        }
    }
}
