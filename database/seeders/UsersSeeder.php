<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\users;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user
        users::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'gender' => 'male',
            'age' => 25,
            'phone' => '1234567890',
            'bio' => 'Test bio',
            'profile_picture' => null,
            'location' => 'Test City',
            'interests' => json_encode(['music', 'sports']),
            'social_links' => json_encode(['facebook' => 'https://facebook.com/test']),
        ]);

        // Create additional random users
        users::factory()->count(29)->create();
    }
    
}
