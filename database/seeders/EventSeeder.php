<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Users;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // create 10 users
        $users = Users::factory()->count(10)->create();

        // create 20 events, assign to existing users and attach random interested users
        Event::factory()->count(20)->make()->each(function ($event) use ($users) {
            $event->user_id = $users->random()->id;
            $event->save();

            // randomly attach 0..5 interested users (exclude creator)
            $possible = $users->where('id', '!=', $event->user_id);
            if ($possible->count()) {
                $count = rand(0, min(5, $possible->count()));
                if ($count > 0) {
                    $interested = $possible->random($count)->pluck('id')->toArray();
                    $event->interestedUsers()->attach($interested);
                }
            }
        });
    }
}
