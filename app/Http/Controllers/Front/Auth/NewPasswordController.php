<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {       
        // $userPhone = session('reg_user_phone');
        // return view('front.auth.reset-password', ['request' => $request, 'userPhone' => $userPhone]);

        return view('front.auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // $validated =  $request->validate([
        //     'token' => ['required'],
        //     // 'email' => ['required', 'email'],
        //     'otp' => ['required', 'string', 'size:6'],
        //     'phone' => ['required', 'string', 'size:10'],
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);

        // $now = now();
        // $customer = Customer::where(['phone' => $validated['phone']])->first();      

        // if (!$customer) {
        //     return redirect('register');
        // } elseif ($customer->phone_verified === 0) {
        //     return redirect('customer.verifyPhone');
        // } elseif ($customer->phone_verified === 1) {

        //     if ($now->isAfter($customer->otp_expire_at)) {
        //         return redirect()->back()->withErrors('OTP Expired');
        //     } elseif (Crypt::decryptString($customer->otp) !== ($validated['otp'])) {
        //         return redirect()->back()->withErrors('Wrong OTP Entered.');
        //     } else {
        //         $customer->update(['otp' => NULL, 'otp_expire_at' => NULL, 'password' => Hash::make($request->password)]);
        //         return redirect('login')->withSuccess('Password updated successfully');
        //     }
        // } else {
        //     return redirect('login');
        // }

        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::broker('customers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}
