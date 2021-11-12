<?php

namespace Tests\Feature\Tweet;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTweetsTweetidTest extends TestCase
{
    use RefreshDatabase;

    private $login_user;
    private $other_user;
    private $exist_tweet_id;
    private $nonexistent_tweet_id;

    public function setup(): void
    {
        parent::setUp();

        $this->seed();

        $this->login_user = User::first();
        $this->other_user = User::orderBy('id', 'DESC')->first();
        $this->exist_tweet_id = Tweet::first()->id + 1;
        $this->nonexistent_tweet_id = Tweet::orderBy('id', 'DESC')->first()->id + 1;
    }

    /**
     * @test
     *
     * @return void
     */
    public function 指定ツイート削除成功(): void
    {
        $tweet_by_login_user = Tweet::create([
            'user_id' => $this->login_user->id,
            'content' => 'test tweet',
        ]);

        $response = $this
            ->actingAs($this->login_user)
            ->delete('api/tweets/'.$tweet_by_login_user->id);

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
    public function 削除失敗_未認証(): void
    {
        $response = $this
            ->delete('api/tweets/'.$this->exist_tweet_id);

        $response
            ->assertStatus(500);
    }

    /**
     * @test
     *
     * @return void
     */
    public function 削除失敗_未所持ツイート(): void
    {
        $tweet_by_other_user = Tweet::create([
            'user_id' => $this->other_user->id,
            'content' => 'test tweet',
        ]);

        $response = $this
            ->actingAs($this->login_user)
            ->delete('api/tweets/'.$tweet_by_other_user->id);

        $response
            ->assertStatus(400)
            ->assertExactJson([
                'result' => false,
                'message' => 'The tweet with the tweet_id is not owned by the login user.',
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function 削除失敗_存在しないツイートID(): void
    {
        $response = $this
            ->actingAs($this->login_user)
            ->delete('api/tweets/'.$this->nonexistent_tweet_id);

        $response
            ->assertStatus(404)
            ->assertExactJson([
                'result' => false,
                'message' => 'The specified id does not exist.',
            ]);
    }

}
