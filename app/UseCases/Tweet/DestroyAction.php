<?php


namespace App\UseCases\Tweet;


use App\Models\Like;
use App\Models\Tweet;
use App\Models\User;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class DestroyAction
{
    public function __invoke(User $user, Tweet $tweet)
    {
        if ($user->id !== $tweet->user_id) {
            throw new BadRequestException('The tweet with the tweet_id is not owned by the login user.');
        }

        $tweet->delete();

        return;
    }
}
