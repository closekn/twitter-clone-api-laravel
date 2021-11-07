<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tweet\StoreRequest;
use App\Http\Resources\Tweet\IndexResource;
use App\Http\Resources\Tweet\StoreResource;
use App\UseCases\Tweet\IndexAction;
use App\UseCases\Tweet\StoreAction;
use Illuminate\Http\Request;

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
}
