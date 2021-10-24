<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Seeders\Tests\AuthSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    const MAX_NAME_LENGTH = 32;
    const MIN_PASSWORD_LENGTH = 8;

    private $registered_user;
    private $new_user = [
        'name' => 'new_user',
        'email' => 'new@example.com',
        'password' => 'new12345'
    ];
    private $safe_name = 'safe_user';
    private $safe_email = 'safe@example.com';
    private $safe_password = 'safe1234';

    public function setup(): void
    {
        parent::setUp();

        $this->seed(AuthSeeder::class);

        $this->registered_user = User::first();
    }

    /**
     * @test
     *
     * @return void
     */
    public function ユーザ登録成功(): void
    {
        $response = $this->post('api/register', $this->new_user);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'result' => true,
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function バリデーションエラー_必須項目無し(): void
    {
        $response = $this->post('api/register');

        $response
            ->assertStatus(400)
            ->assertExactJson([
                'result' => false,
                'errors' => [
                    'name' => [
                        'The name field is required.'
                    ],
                    'email' => [
                        'The email field is required.'
                    ],
                    'password' => [
                        'The password field is required.'
                    ]
                ]
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function バリデーションエラー_ユニーク項目_使用済み(): void
    {
        $response = $this->post('api/register', [
            'name' => $this->registered_user->name,
            'email' => $this->registered_user->email,
            'password' => $this->safe_password
        ]);

        $response
            ->assertStatus(400)
            ->assertExactJson([
                'result' => false,
                'errors' => [
                    'name' => [
                        'The name has already been taken.'
                    ],
                    'email' => [
                        'The email has already been taken.'
                    ]
                ]
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function バリデーションエラー_name_最大長超過(): void
    {
        $response = $this->post('api/register', [
            'name' => str_repeat('a', self::MAX_NAME_LENGTH+1),
            'email' => $this->safe_email,
            'password' => $this->safe_password
        ]);

        $response
            ->assertStatus(400)
            ->assertExactJson([
                'result' => false,
                'errors' => [
                    'name' => [
                        'The name must not be greater than 32 characters.'
                    ]
                ]
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function バリデーションエラー_email_メール形式でない(): void
    {
        $response = $this->post('api/register', [
            'name' => $this->safe_name,
            'email' => 'test',
            'password' => $this->safe_password
        ]);

        $response
            ->assertStatus(400)
            ->assertExactJson([
                'result' => false,
                'errors' => [
                    'email' => [
                        'The email must be a valid email address.'
                    ]
                ]
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function バリデーションエラー_password_最小長未満(): void
    {
        $response = $this->post('api/register', [
            'name' => $this->safe_name,
            'email' => $this->safe_email,
            'password' => str_repeat('a', self::MIN_PASSWORD_LENGTH-1)
        ]);

        $response
            ->assertStatus(400)
            ->assertExactJson([
                'result' => false,
                'errors' => [
                    'password' => [
                        'The password must be at least 8 characters.'
                    ]
                ]
            ]);
    }
}
