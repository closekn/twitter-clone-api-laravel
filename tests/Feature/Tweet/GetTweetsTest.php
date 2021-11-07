<?php

namespace Tests\Feature\Tweet;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetTweetsTest extends TestCase
{
    use RefreshDatabase;

    public function setup(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * @test
     *
     * @return void
     */
    public function 全ツイート一覧取得成功(): void
    {
        $response = $this->get('api/tweets');

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'result' => true
            ])
            ->assertJsonStructure([
                'result',
                'tweets'
            ]);
    }

}
