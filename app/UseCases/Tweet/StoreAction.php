<?php


namespace App\UseCases\Tweet;


use App\Models\Tweet;
use App\Models\User;

class StoreAction
{
    public function __invoke(User $user, object $request): Tweet
    {
        assert($user->exists);
        assert($request->exists);

        $tweet = Tweet::create([
            'user_id' => $user->id,
            'content' => $request->content,
        ]);

        return $tweet;
    }
}
