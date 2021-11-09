<?php


namespace App\UseCases\Like;


use App\Models\Like;
use App\Models\Tweet;
use App\Models\User;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class StoreAction
{
    public function __invoke(User $user, Int $tweet_id): Like
    {
        $tweet = Tweet::find($tweet_id);

        if ($tweet->isLiked($user)) {
            throw new BadRequestException('The tweet with the tweet_id has already been liked.');
        }

        $like = Like::create([
            'user_id' => $user->id,
            'tweet_id' => $tweet->id,
        ]);

        return $like;
    }
}
