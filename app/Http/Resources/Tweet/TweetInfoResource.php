<?php

namespace App\Http\Resources\Tweet;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TweetInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $tweet_at = new Carbon($this->created_at);
        return [
            'tweet_id' => $this->id,
            'user_name' => $this->user->name,
            'content' => $this->content,
            'count_likes' => $this->likedUsers()->count(),
            'date' => ($tweet_at)->format('Y-m-d H:i:s'),
        ];
    }
}
