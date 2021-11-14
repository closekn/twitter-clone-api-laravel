<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\RegisterResource;
use App\Models\User;
use App\UseCases\Auth\RegisterAction;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
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
     *
     * @return Response
     */
    public function login(LoginRequest $request): Response
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)){
            $user = User::whereName($request->name)->first();

            $user->tokens()->delete();
            $token = $user->createToken("login:user{$user->id}")->plainTextToken;

            return response()->json([
                'result' => true,
                'token' => $token
            ], Response::HTTP_OK);
        }

        return response()->json([
            'result' => false,
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
