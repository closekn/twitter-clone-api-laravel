<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\ShowResource;
use App\Models\User;
use App\UseCases\User\ShowAction;

class UserController extends Controller
{
    /**
     * @param User $user
     * @param ShowAction $action
     *
     * @return ShowResource
     */
    public function show(User $user, ShowAction $action): ShowResource
    {
        return new ShowResource(
            $action(
                $user,
            )
        );
    }
}
