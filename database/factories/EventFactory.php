<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'user_id' => Users::factory(), // will create a user if none provided
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'starts_at' => $this->faker->dateTimeBetween('+1 days', '+1 month'),
        ];
    }
}
