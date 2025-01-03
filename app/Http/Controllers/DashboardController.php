<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{UserProfile, FriendRequest};
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $currentUser = Auth::user();

        // Fetch the current user's profile
        $currentUserProfile = $currentUser->profile;

        // Find like-minded profiles (users with shared data)
        $likeMindedProfiles = UserProfile::where('id', '!=', $currentUserProfile->id)
            ->where(function ($query) use ($currentUserProfile) {
                $query
                    ->where('hobbies', $currentUserProfile->hobbies)
                    ->orWhere('language', $currentUserProfile->language)
                    ->orWhere('skills', $currentUserProfile->skills);
            })
            ->take(10) // Limit to 10 matches
            ->with('user') // Include user data for displaying
            ->get();

        // Fetch friend requests where the logged-in user is the receiver
        $friendRequests = FriendRequest::with('sender')
            ->where('receiver_id', $currentUser->id)
            ->where('accepted', false)
            ->get();

        // Pass data to the Inertia Dashboard
        return Inertia::render('Dashboard', [
            'likeMinded' => $likeMindedProfiles,
            'friendRequests' => $friendRequests,
        ]);
    }

    public function sendFriendRequest(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);

        $senderId = Auth::id();
        $receiverId = $request->receiver_id;

        // Check if a friend request already exists
        $existingRequest = FriendRequest::where('sender_id', $senderId)->where('receiver_id', $receiverId)->first();

        if ($existingRequest) {
            return back()->with('error', 'Friend request already sent.');
        }

        // Create a new friend request
        FriendRequest::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
        ]);

        return back()->with('success', 'Friend request sent successfully.');
    }

    public function acceptFriendRequest(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:friend_requests,id',
        ]);

        $friendRequest = FriendRequest::findOrFail($request->request_id);

        // Ensure the authenticated user is the receiver
        if ($friendRequest->receiver_id !== Auth::id()) {
            return back()->withErrors(['message' => 'Unauthorized action.']);
        }

        // Update the friend request as accepted
        $friendRequest->update(['accepted' => true]);

        return back()->with('success', 'Friend request accepted successfully.');
    }
}
