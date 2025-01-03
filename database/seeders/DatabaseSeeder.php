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

    }
}
