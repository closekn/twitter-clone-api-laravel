<?php


namespace App\UseCases\User;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ShowAction
{
    public function __invoke(User $user): User
    {
        return $user;
    }
}
