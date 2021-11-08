<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUsersUseridTest extends TestCase
{
    use RefreshDatabase;

    private $exist_id;
    private $nonexistent_id;

    public function setup(): void
    {
        parent::setUp();

        $this->seed();

        $this->exist_id = User::first()->id;
        $this->nonexistent_id = User::orderBy('id', 'DESC')->first()->id + 1;
    }

    /**
     * @test
     *
     * @return void
     */
    public function 指定ユーザ取得成功(): void
    {
        $response = $this->get('api/users/'.$this->exist_id);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'result' => true
            ])
            ->assertJsonStructure([
                'result',
                'user' => [
                    'user_id',
                    'user_name',
                    'tweets',
                    'liked_tweets'
                ]
            ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function 取得失敗_存在しないユーザID(): void
    {
        $response = $this->get('api/users/'.$this->nonexistent_id);

        $response
            ->assertStatus(404);
    }

}
