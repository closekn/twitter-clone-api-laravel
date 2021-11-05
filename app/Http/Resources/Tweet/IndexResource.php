<?php

namespace App\Http\Resources\Tweet;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
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
            'tweets' => TweetInfoResource::collection($this),
        ];
    }
}
