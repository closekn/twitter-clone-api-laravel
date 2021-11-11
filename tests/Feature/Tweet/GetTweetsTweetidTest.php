<?php

namespace Tests\Feature\Tweet;

use App\Models\Tweet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetTweetsTweetidTest extends TestCase
{
    use RefreshDatabase;

    private $exist_tweet_id;
    private $nonexistent_tweet_id;

    public function setup(): void
    {
        parent::setUp();

        $this->seed();

        $this->exist_tweet_id = Tweet::all()->first()->id;
        $this->nonexistent_tweet_id = Tweet::orderBy('id', 'DESC')->first()->id + 1;
    }

    /**
     * @test
     *
     * @return void
     */
    public function 指定ツイート取得成功(): void
    {
        $response = $this->get('api/tweets/'.$this->exist_tweet_id);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'result' => true
            ])
            ->assertJsonStructure([
                'result',
                'tweet' => [
                    'tweet_id',
                    'user_name',
                    'content',
                    'liked_users',
                    'date',
                ],
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function 取得失敗_存在しないツイートID(): void
    {
        $response = $this->get('api/tweets/'.$this->nonexistent_tweet_id);

        $response
            ->assertStatus(404)
            ->assertExactJson([
                'result' => false,
                'message' => 'The specified id does not exist.',
            ]);
    }

}
