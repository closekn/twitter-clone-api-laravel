<?php


namespace App\UseCases\Tweet;


use App\Models\Tweet;
use App\Models\User;

class StoreAction
{
    public function __invoke(User $user, String $content): Tweet
    {
        $tweet = Tweet::create([
            'user_id' => $user->id,
            'content' => $content,
        ]);

        return $tweet;
    }
}
