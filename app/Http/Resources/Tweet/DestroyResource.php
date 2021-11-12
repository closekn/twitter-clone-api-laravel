<?php

namespace App\Http\Resources\Tweet;

use Illuminate\Http\Resources\Json\JsonResource;

class DestroyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'result' => true,
        ];
    }
}
