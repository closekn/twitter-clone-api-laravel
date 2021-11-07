<?php

namespace Tests\Feature\Tweet;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTweetsTest extends TestCase
{
    use RefreshDatabase;

    const MAX_CONTENT_LENGTH = 140;

    private $login_user;
    private $safe_content = 'Hello! this is Test Tweet!';

    public function setup(): void
    {
        parent::setUp();

        $this->seed();

        $this->login_user = User::first();
    }

    /**
     * @test
     *
     * @return void
     */
    public function ツイート投稿成功(): void
    {
        $response = $this
            ->actingAs($this->login_user)
            ->post('api/tweets', [
                'content' => $this->safe_content,
            ]);

        $response
            ->assertStatus(201)
            ->assertExactJson([
                'result' => true
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function 未認証(): void
    {
        $response = $this
            ->post('api/tweets', [
                'content' => $this->safe_content,
            ]);

        $response
            ->assertStatus(500);
    }

    /**
     * @test
     *
     * @return void
     */
    public function バリデーションエラー_必須項目無し(): void
    {
        $response = $this
            ->actingAs($this->login_user)
            ->post('api/tweets');

        $response
            ->assertStatus(400)
            ->assertExactJson([
                'result' => false,
                'errors' => [
                    'content' => [
                        'The content field is required.'
                    ]
                ]
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function バリデーションエラー_content_最大長超過(): void
    {
        $response = $this
            ->actingAs($this->login_user)
            ->post('api/tweets', [
                'content' => str_repeat('a', self::MAX_CONTENT_LENGTH+1),
            ]);

        $response
            ->assertStatus(400)
            ->assertExactJson([
                'result' => false,
                'errors' => [
                    'content' => [
                        'The content must not be greater than '. self::MAX_CONTENT_LENGTH .' characters.'
                    ]
                ]
            ]);
    }

}
