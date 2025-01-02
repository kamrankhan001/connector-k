<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Generate 500 users and their profiles
        $users = User::factory(500)->create();

        // Attach profiles
        $users->each(function ($user) {
            $user->profile()->create(UserProfile::factory()->make()->toArray());
        });

        // Ensure each user has at least 10 matches
        // $profiles = UserProfile::all();
        // $profiles->each(function ($profile) use ($profiles) {
        //     // Find 10 matches with similar fields
        //     $matches = $profiles
        //         ->where('id', '!=', $profile->id)
        //         ->filter(function ($otherProfile) use ($profile) {
        //             return $otherProfile->hobbies === $profile->hobbies || $otherProfile->language === $profile->language || $otherProfile->skills === $profile->skills;
        //         })
        //         ->take(10);

        //     // Save matches or log them (depending on your implementation)
        //     $profile->matches = $matches; // Example field for demonstration
        // });
    }
}
