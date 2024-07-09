<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Admin;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    public function update_password(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = Admin::find($request -> id);

        if(Hash::check($validated['current_password'], $user -> password)) {
            
            $user -> update([
                'password' => Hash::make($validated['password'])
            ]);

            return back() -> with('status', 'password-updated');
        }

        else {
            return back() -> with('status', 'password-not-updated');
        }
    }
}
