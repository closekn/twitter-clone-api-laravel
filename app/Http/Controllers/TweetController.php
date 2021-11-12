<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tweet\StoreRequest;
use App\Http\Resources\Tweet\DestroyResource;
use App\Http\Resources\Tweet\IndexResource;
use App\Http\Resources\Tweet\StoreResource;
use App\Http\Resources\Tweet\ShowResource;
use App\Models\Tweet;
use App\UseCases\Tweet\DestroyAction;
use App\UseCases\Tweet\IndexAction;
use App\UseCases\Tweet\ShowAction;
use App\UseCases\Tweet\StoreAction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class TweetController extends Controller
{
    /**
     * @param Request $request
     * @param IndexAction $action
     *
     * @return
     */
    public function index(Request $request, IndexAction $action)
    {
        return new IndexResource($action());
    }

    /**
     * @param StoreRequest $request
     * @param StoreAction $action
     *
     * @return
     */
    public function store(StoreRequest $request, StoreAction $action)
    {
        return new StoreResource(
            $action(
                $request->user(),
                $request->content
            )
        );
    }

    /**
     * @param Tweet $tweet
     * @param ShowAction $action
     *
     * @return ShowResource
     */
    public function show(Tweet $tweet, ShowAction $action): ShowResource
    {
        return new ShowResource($action($tweet));
    }

    /**
     * @param Request $request
     * @param Tweet $tweet
     * @param DestroyAction $action
     *
     * @return DestroyResource
     */
    public function destroy(Request $request, Tweet $tweet, DestroyAction $action): DestroyResource
    {
        try {
            return new DestroyResource(
                $action(
                    $request->user(),
                    $tweet,
                )
            );
        } catch (BadRequestException $e) {
            throw $e;
        }
    }
}
