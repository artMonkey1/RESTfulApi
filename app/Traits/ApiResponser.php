<?php


namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\JsonResponse;

trait ApiResponser
{
    protected function successResponse($data, $code){
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code){
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showCollection(Collection $collection, $code = JsonResponse::HTTP_OK){
        $transformer = $collection->first()->collectionTransformer;
        $collection = $this->transformData($collection, $transformer);

        return $this->successResponse($collection, $code);
    }

    protected function showOne(Model $instance, $code = JsonResponse::HTTP_OK){
        $transformer = $instance->transformer;
        $instance = $this->transformData($instance, $transformer);

        return $this->successResponse(['data' => $instance], $code);
    }

    protected function showMessage($message, $code = JsonResponse::HTTP_OK){
        return $this->successResponse(['data' => $message], $code);
    }

    protected function transformData($data, $transformer){
        return new $transformer($data);
    }
}
