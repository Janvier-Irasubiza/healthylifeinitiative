<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\AdminProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Admin;
use App\Models\User;
use File;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('client.profile')->with('status', 'profile-updated');
    }

    public function edit_profile(AdminProfileUpdateRequest $request): RedirectResponse
    {
        $user = Admin::find($request -> id);

        if ($user -> isDirty('email')) {
            $user -> email_verified_at = null;
        }

        $data = $request->validated();
        
        $user -> fill($data);

        $user -> update($data);

        return Redirect::route('admin.profile')->with('status', 'profile-updated');
    }
  
  public function UpdateProfilePicture(Request $request) {
  
    $request->validate([
      'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = User::find($request->user);
    
    if($request->hasFile('profile_image')) {
      	$photo = $request -> file('profile_image') -> getClientOriginalName();
        if (File::exists(public_path('images/profile_pictures/'.$user->profile_picture))) {
          	File::delete(public_path('images/profile_pictures/'.$user->profile_picture));
			$request -> file('profile_image') -> move(public_path('images/profile_pictures/'), $photo);
          	$user->profile_picture = $photo;
        	$user->save();
        }
    }
    
    return back();
  }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
