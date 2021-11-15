<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Http\Resources\Auth\RegisterResource;
use App\UseCases\Auth\LoginAction;
use App\UseCases\Auth\RegisterAction;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @param RegisterAction $action
     *
     * @return RegisterResource
     */
    public function register(RegisterRequest $request, RegisterAction $action): RegisterResource
    {
        return new RegisterResource(
            $action(
                (object) $request->validated()
            )
        );
    }

    /**
     * @param LoginRequest $request
     * @param LoginAction $action
     *
     * @return LoginResource
     */
    public function login(LoginRequest $request, LoginAction $action): LoginResource
    {
        try {
            return new LoginResource(
                $action(
                    (object) $request->validated(),
                )
            );
        } catch (BadRequestException $e) {
            throw $e;
        }
    }
}
