<?php


namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

trait ApiResponser
{
    protected function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showCollection($collection)
    {
        $transformer = $collection->first()->transformer;

        $collection = $this->transformData($collection, $transformer);
        $collection = $this->cacheResponse($collection);

        return $collection;
    }

    protected function showOne(Model $instance, $code = JsonResponse::HTTP_OK)
    {
        $transformer = $instance->transformer;
        $instance = $this->transformData($instance, $transformer);

        return $this->successResponse(['data' => $instance], $code);
    }

    protected function showMessage($message, $code = JsonResponse::HTTP_OK)
    {
        return $this->successResponse(['data' => $message], $code);
    }

    protected function transformData($data, $transformer)
    {
        if($data instanceof Model){
            return new $transformer($data);
        }

        return $transformer::collection($data);
    }

    protected function cacheResponse($data)
    {
        $url = request()->url();
        $queryString = request()->query();
        ksort($queryString);
        $queryString = http_build_query($queryString);

        $url = "{$url}?{$queryString}";

        return \Cache::remember($url, 30/60, function() use ($data){
            return $data;
        });
    }
}
