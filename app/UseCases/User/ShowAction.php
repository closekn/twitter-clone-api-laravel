<?php


namespace App\UseCases\User;


use App\Models\User;

class ShowAction
{
    public function __invoke(User $user): User
    {
        assert($user->exists);

        return $user;
    }
}
