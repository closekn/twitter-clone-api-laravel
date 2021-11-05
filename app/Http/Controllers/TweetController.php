<?php

namespace App\Http\Controllers;

use App\Http\Resources\Tweet\IndexResource;
use App\UseCases\Tweet\IndexAction;
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
}
