<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\users>
 */
class UsersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // Default password for testing
            'created_at' => now(),
            'updated_at' => now(),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'age' => $this->faker->numberBetween(18, 80),
            'phone' => $this->faker->phoneNumber(),            
            'bio' => $this->faker->sentence(50),
            'profile_picture' => $this->faker->imageUrl(200, 200, 'people'),
            'location' => $this->faker->city(),
            'interests' => json_encode($this->faker->randomElements(['music', 'sports', 'travel', 'reading', 'gaming'], 3)),
            'social_links' => json_encode([
                'facebook' => $this->faker->url(),
                'twitter' => $this->faker->url(),
                'instagram' => $this->faker->url(),
            ]),
            'is_verified' => $this->faker->boolean(80), // 80% chance of being true
            
        ];
    }
}
