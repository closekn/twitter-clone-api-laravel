<?php


namespace App\UseCases\Auth;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class LoginAction
{
    public function __invoke(object $request): object
    {
        assert($request->exists);
        $credentials = (array) $request;

        if (! Auth::attempt($credentials)){
            throw new BadRequestException('\'name\' or \'password\' is wrong.');
        }

        $user = User::whereName($request->name)->first();

        $user->tokens()->delete();
        $token = $user->createToken("login:user{$user->id}")->plainTextToken;

        return (object) [
            'token' => $token,
        ];
    }
}
