<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Tweet\TweetInfoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'result' => true,
            'user' => [
                'user_id' => $this->id,
                'user_name' => $this->name,
                'tweets' => TweetInfoResource::collection($this->tweets),
                'liked_tweets' => TweetInfoResource::collection($this->likedTweets),
            ],
        ];
    }
}
