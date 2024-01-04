<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

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
    public function update(Request $request, User $user): RedirectResponse
    {
       $this->validate($request, [
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:4089',
           'name' => 'required|string|max:255',
        ]);
        if (!$request->hasFile('photo')) {
            $user->photo = 'images/default.jpg';
        }
        else
        {
            // Delete the old image from storage
            if ($user->photo) {
                Storage::disk('user')->delete($user->photo);
            }

            // Upload the new image
            $image = $request->file('photo');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            // Log the image file name
            Storage::disk('user')->put($imageName, file_get_contents($image));

            // Set the new image URL in the Product instance
            $user->photo = $imageName;

            // Update other user attributes
            $user->update($request->except(['photo', '_token', '_method']));


            // Save the user model
            $user->save();
        }

        // 如果 email 發生變化，重置 email_verified_at
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        dd($request->all());
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
