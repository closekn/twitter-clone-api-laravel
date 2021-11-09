<?php

namespace Tests\Feature\Like;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostLikeTest extends TestCase
{
    use RefreshDatabase;

    const MAX_CONTENT_LENGTH = 140;

    private $login_user;
    private $liked_tweet_id;
    private $nonexistent_tweet_id;

    public function setup(): void
    {
        parent::setUp();

        $this->seed();

        $this->login_user = User::first();
        $this->liked_tweet_id = $this->login_user->likedTweets->first()->id;
        $this->nonexistent_tweet_id = Tweet::orderBy('id', 'DESC')->first()->id + 1;
    }

    /**
     * @test
     *
     * @return void
     */
    public function いいね付与成功(): void
    {
        $new_tweet = Tweet::create([
            'user_id' => $this->login_user->id,
            'content' => 'test tweet',
        ]);

        $response = $this
            ->actingAs($this->login_user)
            ->post('api/like', [
                'tweet_id' => $new_tweet->id,
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
    public function 付与失敗_既付与ツイート対象(): void
    {
        $response = $this
            ->actingAs($this->login_user)
            ->post('api/like', [
                'tweet_id' => $this->liked_tweet_id,
            ]);

        $response
            ->assertStatus(400)
            ->assertExactJson([
                'result' => false,
                'message' => 'The tweet with the tweet_id has already been liked.',
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function 付与失敗_未認証(): void
    {
        $new_tweet = Tweet::create([
            'user_id' => $this->login_user->id,
            'content' => 'test tweet',
        ]);

        $response = $this
            ->post('api/like', [
                'tweet_id' => $new_tweet->id,
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
            ->post('api/like');

        $response
            ->assertStatus(400)
            ->assertExactJson([
                'result' => false,
                'errors' => [
                    'tweet_id' => [
                        'The tweet id field is required.'
                    ]
                ]
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function バリデーションエラー_tweetId_存在しないID(): void
    {
        $response = $this
            ->actingAs($this->login_user)
            ->post('api/like', [
                'tweet_id' => $this->nonexistent_tweet_id,
            ]);

        $response
            ->assertStatus(400)
            ->assertExactJson([
                'result' => false,
                'errors' => [
                    'tweet_id' => [
                        'The selected tweet id is invalid.'
                    ]
                ]
            ]);
    }

}
