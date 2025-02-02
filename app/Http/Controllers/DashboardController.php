<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{UserProfile, FriendRequest};
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get the currently authenticated user
        $currentUser = Auth::user();
        $currentUserProfile = $currentUser->profile;

        // Get the search query and gender filter from the request (if any)
        $searchQuery = $request->get('search', '');
        $filterGender = $request->get('filterGender', 'both'); // Default to 'both' if not provided

        // Find like-minded profiles (users with shared data)
        $likeMindedProfiles = UserProfile::where('id', '!=', $currentUserProfile->id)
            ->where(function ($query) use ($currentUserProfile) {
                $query
                    ->where('hobbies', $currentUserProfile->hobbies)
                    ->orWhere('language', $currentUserProfile->language)
                    ->orWhere('skills', $currentUserProfile->skills);
            })
            ->whereHas('user', function ($query) use ($searchQuery, $filterGender) {
                if ($searchQuery) {
                    $query->where('name', 'like', "%{$searchQuery}%");
                }
            })
            ->where(function ($query) use ($filterGender) {
                if ($filterGender !== 'both') {
                    $query->where('gender', $filterGender);
                }
            })
            ->take(10) // Limit to 10 matches
            ->with('user') // Include user data for displaying
            ->get();

        // Fetch friend requests where the logged-in user is the receiver
        $friendRequests = FriendRequest::with('sender.profile')
            ->where('receiver_id', $currentUser->id)
            ->where('accepted', false)
            ->get();

        // Pass data to the Inertia Dashboard
        return Inertia::render('Dashboard', [
            'likeMinded' => $likeMindedProfiles,
            'friendRequests' => $friendRequests,
            'filterGender' => $filterGender,
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
