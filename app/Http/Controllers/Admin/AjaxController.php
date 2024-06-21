<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\LedgerDoc;
use App\Models\LegalDoc;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PhoneOtp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Observers\PageObserver;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class AjaxController extends Controller
{
    public function statusChange(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'modelName' => 'required|string',
            'modelId' => 'required|numeric',
            'status' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'msg' => 'Status could not be changed']);
        }

        $validated = $validator->validated();
        $status = ($validated['status'] == 'true') ? 1 : 0;
        // dd($validated);

        // $model = $validated['modelName'];

        $updateState = DB::table($validated['modelName'])->where('id', $validated['modelId'])->update(['status' => $status, 'updated_at' => Carbon::now()]);

        if ($validated['modelName'] == 'pages') {
            Cache::forget('cmsPages');
        } elseif ($validated['modelName'] == 'categories') {
            Cache::forget('headerCategories');
        }

        if ($updateState) {
            return response()->json(['error' => false, 'msg' => 'List' . ' status updated']);
        } else {
            return response()->json(['error' => true, 'msg' => 'List' . ' not updated']);
        }
    }

    public function getCustomerLegalDocs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customerAdharId' => 'required|string|size:12'
        ]);
        $validated = $validator->validated();

        if ($validator->fails()) {
            return response()->json(['error' => true, 'msg' => 'Customer id not found']);
        }

        $nocDocList = LegalDoc::where('aadhaar_no', $validated['customerAdharId'])->get()->toArray();
        $ledgersDocList = LedgerDoc::where('aadhaar_no', $validated['customerAdharId'])->get()->toArray();

        $responseData = [
            'nocs' => $nocDocList ?? [],
            'ledgers' => $ledgersDocList ?? []
        ];


        if (!empty($responseData) || $responseData !== null) {
            return response()->json(['error' => false, 'data' => $responseData]);
        } else {
            return response()->json(['error' => true, 'data' => []]);
        }
    }

    public function sendRegOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phoneNo' => ['required', 'string', 'size:10'],
        ]);
        $validated = $validator->validated();

        if ($validator->fails()) {
            return response()->json(['error' => true, 'msg' => 'Invalid phone number.', 'data' => 0]);
        }

        $customer = Customer::where('phone',  $validated['phoneNo'])->first();

        if (!empty($customer) || $customer !== null) {
            return response()->json(['error' => true, 'msg' => 'Phone number already registered.', 'data' => 0]);
        }

        $customerOldOtp = PhoneOtp::where('phone',  $validated['phoneNo'])->first();

        if (!empty($customerOldOtp) && $customerOldOtp->verified == 1) {
            return response()->json(['error' => false, 'msg' => 'Phone number already verified. Please fill the other data.', 'data' => 1]);
        }

        $now = now();
        $otp = generateOtp();
        Log::info($otp);
        $otpencrypted = Crypt::encryptString($otp);
        $otpExpiry = $now->addMinutes(10);


        if ($customerOldOtp) {
            $customerOldOtp->update(['otp' => $otpencrypted, 'otp_expire_at' => $otpExpiry]);
            return response()->json(['error' => false, 'msg' => 'OTP sent to your phone again.', 'data' => 0]);
        } else {
            PhoneOtp::create([
                'phone' => $validated['phoneNo'],
                'otp' => $otpencrypted,
                'otp_expire_at' => $otpExpiry
            ]);
            return response()->json(['error' => false, 'msg' => 'OTP sent to your phone.', 'data' => 0]);
        }
    }

    public function verifyRegOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phoneNo' => ['required', 'string', 'size:10'],
            'otp' => ['required', 'string', 'size:6'],
        ]);
        $validated = $validator->validated();

        if ($validator->fails()) {
            return response()->json(['error' => true, 'msg' => 'Invalid otp.']);
        }

        $customerSavedOtp = PhoneOtp::where('phone',  $validated['phoneNo'])->first();
        $now = now();

        if (!empty($customerSavedOtp)) {
            if ($now->isAfter($customerSavedOtp->otp_expire_at)) {
                return response()->json(['error' => true, 'msg' => 'OTP Expired, please request again for a OTP.']);
            }

            if (Crypt::decryptString($customerSavedOtp->otp) === $validated['otp']) {
                $customerSavedOtp->update(['otp' => null, 'otp_expire_at' => null, 'verified' => 1]);
                return response()->json(['error' => false, 'msg' => 'Phone number verified successfully.']);
            } else {
                return response()->json(['error' => true, 'msg' => 'Wrong OTP entered.']);
            }
        } else {
            return response()->json(['error' => true, 'msg' => 'Invalid OTP.']);
        }
    }
}
