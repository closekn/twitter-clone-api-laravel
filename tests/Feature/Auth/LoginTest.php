<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Seeders\Tests\AuthSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    const MAX_NAME_LENGTH = 32;
    const MIN_PASSWORD_LENGTH = 8;

    private $registered_user;
    private $registered_password = 'test1234';
    private $safe_name = 'safe_user';
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
    public function ログイン成功(): void
    {
        $response = $this->post('api/login', [
            'name' => $this->registered_user->name,
            'password' => $this->registered_password
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'result' => true
            ])
            ->assertJsonStructure([
                'result',
                'token'
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function ログイン失敗_誤パスワード(): void
    {
        $response = $this->post('api/login', [
            'name' => $this->registered_user->name,
            'password' => $this->safe_password
        ]);

        $response
            ->assertStatus(500)
            ->assertExactJson([
                'result' => false,
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function ログイン失敗_未登録ユーザ(): void
    {
        $response = $this->post('api/login', [
            'name' => $this->safe_name,
            'password' => $this->safe_password
        ]);

        $response
            ->assertStatus(500)
            ->assertExactJson([
                'result' => false,
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function バリデーションエラー_必須項目無し(): void
    {
        $response = $this->post('api/login');

        $response
            ->assertStatus(400)
            ->assertExactJson([
                'result' => false,
                'errors' => [
                    'name' => [
                        'The name field is required.'
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
    public function バリデーションエラー_name_最大長超過(): void
    {
        $response = $this->post('api/login', [
            'name' => str_repeat('a', self::MAX_NAME_LENGTH+1),
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
    public function バリデーションエラー_password_最小長未満(): void
    {
        $response = $this->post('api/login', [
            'name' => $this->safe_name,
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
