<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\PhoneOtp;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('front.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . Customer::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'aadhaar' => ['required', 'string', 'size:12', 'unique:' . Customer::class],
            'phone' => ['required', 'string', 'size:10', 'unique:' . Customer::class],
        ]);
        
        // $verifiedCustomerOtp = PhoneOtp::where(['phone' =>$validated['phone'], 'verified' => 1])->first();

        // if (empty($verifiedCustomerOtp)) {
        //     return redirect()->back()->withErrors('Please verify your phone number before register.');
        // }
        
        // $now = now();
        // $otp = generateOtp();
        // $otpExpiry = $now->addMinutes(10);

        // Log::info($otp);

        $user = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'aadhaar' => $request->aadhaar,
            'password' => Hash::make($request->password),
            'phone_verified' => 1
            // 'otp' => Crypt::encryptString($otp),
            // 'otp_expire_at' => $otpExpiry
        ]);

        // $verifiedCustomerOtp->delete();

        event(new Registered($user));

        Auth::guard('front')->login($user);


        // session(['reg_user_phone' => $validated['phone']]);
        return redirect(RouteServiceProvider::HOME);
        // return redirect()->route('customer.verifyPhone');
        // return redirect()->route('login');
    }

    public function verifyPhone(Request $request)
    {
        $userPhone = session('reg_user_phone');

        if ($request->session()->has('reg_user_phone')) {
            $userPhone = session('reg_user_phone');
            return view('front.auth.verify-phone', compact(['userPhone']));
        } else {
            return redirect('login');
        }
        // dd($userEmail);        
    }

    public function verifyPhoneSubmit(Request $request)
    {
        $validated = $request->validate([
            'user_phone' => ['required', 'string', 'size:10',],
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $now = now();
        $customer = Customer::where(['phone' => $validated['user_phone']])->first();

        if (!$customer) {
            return redirect('register');
        } elseif ($customer->phone_verified === 1) {
            return redirect('login');
        } elseif ($customer->otp) {
            if ($now->isAfter($customer->otp_expire_at)) {
                return redirect()->back()->withErrors('OTP Expired');
            } elseif (Crypt::decryptString($customer->otp) !== ($validated['otp'])) {
                return redirect()->back()->withErrors('Wrong OTP Entered');
            } else {
                $request->session()->forget('reg_user_phone');
                $customer->update(['otp' => NULL, 'otp_expire_at' => NULL, 'phone_verified' => 1]);
                return redirect('login')->withSuccess('Phone number verified');
            }
        } else {
            return redirect('login');
        }

        return redirect('login');
    }

    public function resendOtp(Request $request)
    {
        $validated = $request->validate([
            'user_phone' => ['required', 'string', 'size:10',],
        ]);
        $now = now();
        $customer = Customer::where(['phone' => $validated['user_phone']])->first();

        if (!$customer) {
            return redirect('register');
        } elseif ($customer->phone_verified === 1 && $customer->otp === "" && $customer->otp_expire_at === "") {
            return redirect('login');
        } elseif ($customer->otp) {
            if ($now->isAfter($customer->otp_expire_at)) {
                $newOtp = generateOtp();                
                $otpExpiry = $now->addMinutes(10);
                $customer->update(['otp' => Crypt::encryptString($newOtp), 'otp_expire_at' => $otpExpiry]);
                Log::info($newOtp);
                return redirect()->back()->withSuccess('OTP sent to your phone');
            } elseif ($now->isBefore($customer->otp_expire_at)) {                      
                $otpExpiry = $now->addMinutes(10);
                $customer->update(['otp_expire_at' => $otpExpiry]);
                Log::info(Crypt::decryptString($customer->otp));
                return redirect()->back()->withSuccess('OTP sent to your phone');
            } else {
                return redirect('login');
            }
        } else {
            return redirect('login');
        }
    }


}
