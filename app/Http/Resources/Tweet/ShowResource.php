<?php

namespace App\Http\Resources\Tweet;

use App\Http\Resources\User\UserInfoResource;
use Carbon\Carbon;
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
        $tweet_at = new Carbon($this->created_at);
        return [
            'result' => true,
            'tweet' => [
                'tweet_id' => $this->id,
                'user_name' => $this->user->name,
                'content' => $this->content,
                'liked_users' => UserInfoResource::collection($this->likedUsers),
                'date' => ($tweet_at)->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
