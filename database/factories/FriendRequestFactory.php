<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FriendRequest>
 */
class FriendRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();

        $receiverId = $this->faker->randomElement($userIds);
        $senderId = $this->faker->randomElement(array_diff($userIds, [$receiverId])); // Ensure sender != receiver

        return [
            'receiver_id' => $receiverId,
            'sender_id' => $senderId,
            'accepted' => $this->faker->boolean(10),
        ];
    }
}
