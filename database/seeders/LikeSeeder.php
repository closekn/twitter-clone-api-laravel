<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $tweets = Tweet::all();

        foreach ($users as $user) {
            foreach ($tweets as $tweet) {
                if ( (bool)random_int(0, 1) ) {
                    Like::create([
                        'user_id' => $user->id,
                        'tweet_id' => $tweet->id,
                    ]);
                }
            }
        }
    }
}
