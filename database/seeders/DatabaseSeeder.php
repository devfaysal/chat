<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Message;
use App\Models\Participant;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $current_user = User::factory()->create([
            'name' => 'Faysal Ahamed',
            'email' => 'devfaysal@gmail.com',
        ]);

        $users = User::whereNotIn('id', [$current_user->id])->get();
        foreach($users as $user){
            $room = Room::create([]);
            Participant::create([
                'user_id' => $current_user->id,
                'room_id' => $room->id,
            ]);
            Participant::create([
                'user_id' => $user->id,
                'room_id' => $room->id,
            ]);
            Message::create([
                'user_id' => $current_user->id,
                'room_id' => $room->id,
                'message' => fake()->sentence()
            ]);
            Message::create([
                'user_id' => $user->id,
                'room_id' => $room->id,
                'message' => fake()->sentence()
            ]);
            Message::create([
                'user_id' => $current_user->id,
                'room_id' => $room->id,
                'message' => fake()->sentence()
            ]);
            Message::create([
                'user_id' => $user->id,
                'room_id' => $room->id,
                'message' => fake()->sentence()
            ]);
        }
        
    }
}
