<?php

namespace Tests\Feature\Like;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteLikeTest extends TestCase
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
    public function いいね削除成功(): void
    {
        $response = $this
            ->actingAs($this->login_user)
            ->delete('api/like', [
                'tweet_id' => $this->liked_tweet_id,
            ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'result' => true
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function 削除失敗_未付与ツイート対象(): void
    {
        $new_tweet = Tweet::create([
            'user_id' => $this->login_user->id,
            'content' => 'test tweet',
        ]);

        $response = $this
            ->actingAs($this->login_user)
            ->delete('api/like', [
                'tweet_id' => $new_tweet->id,
            ]);

        $response
            ->assertStatus(400)
            ->assertExactJson([
                'result' => false,
                'message' => 'The tweet with the tweet_id has not been liked yet.',
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
            ->delete('api/like', [
                'tweet_id' => $this->liked_tweet_id,
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
            ->delete('api/like');

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
            ->delete('api/like', [
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
