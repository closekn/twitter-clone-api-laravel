<?php


namespace App\UseCases\Tweet;


use App\Models\Tweet;
use Illuminate\Database\Eloquent\Collection;

class IndexAction
{
    public function __invoke(): Collection
    {
        $tweets = Tweet::orderBy('created_at', 'DESC')
            ->with('user')
            ->with('user', 'likedUsers')
            ->get();

        return $tweets;
    }
}
