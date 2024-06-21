<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ApiUserController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->post(), [
                'name' => ['required', 'string', 'max:255', 'min:3'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . Customer::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'contact' => ['required', 'string', 'max:15', 'min:10'],
                'institution' => ['required', 'string', 'max:100', 'min:3'],
                'country' => ['required', 'string', 'max:50', 'min:3'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->getMessageBag()->toArray();
                return response()->json([
                    'status' => false,
                    'message' => "Invalid Data",
                    'errors' => $errors
                ], 400);
            } else {
                $appUser = Customer::create([
                    'name' => $validator->validated()['name'],
                    'email' => $validator->validated()['email'],
                    'contact' => $validator->validated()['contact'],
                    'institution' => $validator->validated()['institution'],
                    'country' => $validator->validated()['country'],
                    'password' => Hash::make($validator->validated()['password']),

                ]);
                event(new Registered($appUser));
                return response()->json([
                    'status' => true,
                    'message' => 'User Registered Successfully',
                    'token' => $appUser->createToken("UnaniToken")->plainTextToken
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Internal Server error",
                'errors' => ['general' => $th->getMessage()]
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->post(), [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', Rules\Password::defaults()],
            ]);

            if ($validator->fails()) {
                $errors = $validator->getMessageBag()->toArray();
                return response()->json([
                    'status' => false,
                    'message' => "Invalid Data",
                    'errors' => $errors
                ], 401);
            }

            if (!Auth::guard('front')->attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Data',
                    'errors' => ['general' => 'Email & Password does not match with our record.']
                ], 401);
            }
            $user = Customer::where('email', $validator->validated()['email'])->first();
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("UnaniToken")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Internal Server error",
                'errors' => ['general' => $th->getMessage()]
            ], 500);
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->post(), [
                'email' => ['required', 'string', 'email', 'max:255', 'exists:customers,email'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->getMessageBag()->toArray();
                return response()->json([
                    'status' => false,
                    'message' => "Invalid Data",
                    'errors' => $errors
                ], 401);
            }

            $status = Password::broker('customers')->sendResetLink(
                $request->only('email')
            );

            if ($status == Password::RESET_LINK_SENT) {
                return response()->json([
                    'status' => true,
                    'message' => 'Reset password link sent on email successfully.',
                    'errors' => ['general' => 'Reset password link sent on email successfully.']
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Error occurred on sending mail.',
                    'errors' => ['general' => 'Error occurred on sending mail.']
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Internal Server error",
                'errors' => ['general' => $th->getMessage()]
            ], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        
        try {
            $validator = Validator::make($request->post(), [
                'current_password' => ['required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                }],
                'password' => ['required', Rules\Password::defaults(), 'confirmed'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->getMessageBag()->toArray();
                return response()->json([
                    'status' => false,
                    'message' => "Invalid Data",
                    'errors' => $errors
                ], 401);
            }

            $user =Auth::user();
            $userFound = Customer::find($user->id);           

            $update = $userFound->update([
                'password' => Hash::make($validator->validated()['password']),
            ]);

            if ($update) {
                return response()->json([
                    'status' => true,
                    'message' => 'Password updated successfully.',
                    'errors' => ['general' => 'Password updated successfully.']
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Error occurred on updating password.',
                    'errors' => ['general' => 'Error occurred on updating password.']
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Internal Server error",
                'errors' => ['general' => $th->getMessage()]
            ], 500);
        }
    }
    public function deleteProfile(Request $request)
    {
        
        try {
            $validator = Validator::make($request->post(), [
                'password' => ['required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                }]
            ]);

            if ($validator->fails()) {
                $errors = $validator->getMessageBag()->toArray();
                return response()->json([
                    'status' => false,
                    'message' => "Invalid Data",
                    'errors' => $errors
                ], 401);
            }

            $user =Auth::user();
            $userFound = Customer::find($user->id);  
            $userFound->tokens()->delete();
            
            $deleteUser = $userFound->delete();            

            if ($deleteUser) {
                return response()->json([
                    'status' => true,
                    'message' => 'Profile deleted successfully.',
                    'errors' => ['general' => 'Profile deleted successfully.']
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Error occurred.',
                    'errors' => ['general' => 'Error occurred.']
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "Internal Server error",
                'errors' => ['general' => $th->getMessage()]
            ], 500);
        }
    }   

}
