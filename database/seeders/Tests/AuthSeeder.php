<?php

namespace Database\Seeders\Tests;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::create([
            'name' => 'test_user',
            'email' => 'test@example.com',
            'password' => Hash::make('test1234'),
        ]);
    }
}
