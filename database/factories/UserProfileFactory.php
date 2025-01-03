<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hobbies = ['reading', 'sports', 'music', 'gaming', 'traveling'];
        $languages = ['English', 'French', 'Spanish', 'German', 'Italian'];
        $skills = ['coding', 'writing', 'designing', 'teaching', 'marketing'];

        return [
            'university' => $this->faker->company,
            'area' => $this->faker->streetName,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'hobbies' => $this->faker->randomElement($hobbies),
            'occupation' => $this->faker->jobTitle,
            'age' => $this->faker->numberBetween(18, 60),
            'education' => $this->faker->randomElement(['High School', 'Bachelor', 'Master', 'PhD']),
            'language' => $this->faker->randomElement($languages),
            'skills' => $this->faker->randomElement($skills),
            'image' => $this->faker->imageUrl(600, 900, 'people'), // Generate placeholder image
        ];
    }
}
