<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UserMatchingProfileRequest;
use App\Models\UserProfile;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'userProfile' => $request->user()->profile,
            'status' => session('status'),
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

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function save(UserMatchingProfileRequest $request, UserProfile $userProfile = null)
    {
        // If a profile is passed, update; otherwise, create a new one.
        if ($userProfile) {
            // Ensure the authenticated user owns the profile
            if ($userProfile->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            $userProfile->update($request->validated());

            return redirect()->back()->with('success', 'Profile updated successfully.');
        } else {
            // Create a new profile
            $data = $request->validated();
            $data['user_id'] = Auth::id();

            UserProfile::create($data);

            return redirect()->back()->with('success', 'Profile created successfully.');
        }
    }
}
