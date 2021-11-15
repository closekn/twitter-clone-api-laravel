<?php


namespace App\UseCases\Auth;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterAction
{
    public function __invoke(object $request): User
    {
        assert($request->exists);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $user;
    }
}
