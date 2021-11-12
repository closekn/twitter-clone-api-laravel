<?php


namespace App\UseCases\Tweet;


use App\Models\Tweet;
use Illuminate\Database\Eloquent\Collection;

class ShowAction
{
    public function __invoke(Tweet $tweet): Tweet
    {
        return $tweet;
    }
}
