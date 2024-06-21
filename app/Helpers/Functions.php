
<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

if (!function_exists('asset_path')) {
    function asset_path($path = null)
    {
        $prefix = env('ASSET_BASE_PATH');
        return $prefix . $path;
    }
}

if (!function_exists('random_fileString')) {
    function random_fileString()
    {
        $output = Config::get('app_url.filename_append_str') . '-' . time() . '-' . mt_rand(1000000, 9999999);
        return $output;
    }
}

if (!function_exists('upload_file')) {
    function upload_file($requestImg, $slug, $staticPath = "upload/", $width = 300, $height = null)
    {
        $image = $requestImg;
        $new_image = random_fileName($slug, $image->extension());

        $path = $staticPath;
        $imagePath = $path . $new_image;

        $pathReal = Config::get('app_url.asset_base_path') . $path;
        $imagePathReal = Config::get('app_url.asset_base_path') . $imagePath;

        if (!File::exists($pathReal)) {
            File::makeDirectory($pathReal, 0755, true, true);
        }
        $iim = Image::make($image)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->save($imagePathReal);

        return $imagePath;
    }
}

if (!function_exists('generateOtp')) {
    function generateOtp($length = 6)
    {
        $generator = "1357902468";

        $result = "";

        for ($i = 1; $i <= $length; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }

        return $result;
    }
}

if (!function_exists('sendTextLocalSms')) {
    function sendTextLocalSms($numberArray,  $message = "", $template = 'REGOTP')
    {
        try {
            // Account details
            $apiKey = urlencode(env('TEXTLOCAL_API_KEY'));
            // Message details
            // $numbers = $numberArray;
            $sender = urlencode("TXTLCL");
            // $otp = $data['otp'];
            // $message = rawurlencode("Welcome to JB Legal. Your registration OTP is $otp. Use this OTP within next 10 minutes.");

            $numbers = implode(",", $numberArray);

            // Prepare data for POST request
            $data = array("apikey" => $apiKey, "numbers" => $numbers, "sender" => $sender, "message" => $message);
            // Send the POST request with cURL
            $ch = curl_init("https://api.textlocal.in/send/");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            // Process your response here
            echo $response;
            Log::info($response);
        } catch (\Throwable $th) {
            //throw $th;
            Log::info($th->getMessage());
        }
    }
}

?>