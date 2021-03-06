<?php

namespace App\Http\Controllers;

use App\Http\Requests\Like\DestroyRequest;
use App\Http\Requests\Like\StoreRequest;
use App\Http\Resources\Like\DestroyResource;
use App\Http\Resources\Like\StoreResource;
use App\UseCases\Like\DestroyAction;
use App\UseCases\Like\StoreAction;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class LikeController extends Controller
{
    /**
     * @param StoreRequest $request
     * @param StoreAction $action
     *
     * @return StoreResource
     */
    public function store(StoreRequest $request, StoreAction $action): StoreResource
    {
        try {
            return new StoreResource(
                $action(
                    $request->user(),
                    (object) $request->validated(),
                )
            );
        } catch (BadRequestException $e) {
            throw $e;
        }
    }

    /**
     * @param DestroyRequest $request
     * @param DestroyAction $action
     *
     * @return DestroyResource
     */
    public function destroy(DestroyRequest $request, DestroyAction $action): DestroyResource
    {
        try {
            return new DestroyResource(
                $action(
                    $request->user(),
                    (object) $request->validated(),
                )
            );
        } catch (BadRequestException $e) {
            throw $e;
        }
    }
}
