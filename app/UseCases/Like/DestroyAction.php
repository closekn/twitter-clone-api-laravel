<?php


namespace App\UseCases\Like;


use App\Models\Like;
use App\Models\Tweet;
use App\Models\User;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class DestroyAction
{
    public function __invoke(User $user, Int $tweet_id)
    {
        $tweet = Tweet::find($tweet_id);

        if (!$tweet->isLiked($user)) {
            throw new BadRequestException('The tweet with the tweet_id has not been liked yet.');
        }

        $user->likedTweets()->detach($tweet_id);

        return;
    }
}
