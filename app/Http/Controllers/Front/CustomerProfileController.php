<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\CustomerProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CustomerProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {        
        return view('front.profile.edit', [
            'user' => $request->user('front'),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param  \App\Http\Requests\Front\CustomerProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CustomerProfileUpdateRequest $request)
    {
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
        dd();
        $request->user('front')->fill($request->validated());

        if ($request->user('front')->isDirty('email')) {
            $request->user('front')->email_verified_at = null;
        }
        
        $request->user('front')->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password:front'],
        ]);

        $user = $request->user('front');
        
        Auth::guard('front')->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
