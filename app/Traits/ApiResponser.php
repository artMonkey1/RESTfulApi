<?php


namespace App\Traits;

use App\Http\Resources\ApiResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
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

    protected function showCollection(Collection $collection, $code = JsonResponse::HTTP_OK)
    {
        $transformer = $collection->first()->collectionTransformer;

        $collection = $this->sortData($collection, $transformer);
        $collection = $this->filterData($collection, $transformer);
        $collection = $this->paginate($collection);
        $collection = $this->transformData($collection, $transformer);
        $collection = $this->cacheResponse($collection);

        return $this->successResponse($collection, $code);
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

    protected function sortData(Collection $collection, ApiResource $transformer)
    {
        if(request()->has('sort_by')){
            $attribute  = $transformer::originalAttribute(request()->sort_by);
            $collection->sortBy->$attribute;
        }
        return $collection;
    }

    protected function filterData(Collection $collection, ApiResource $transformer)
    {
        foreach(request()->query() as $query => $value){
            $attribute = $transformer::originalAttribute($query);

            if(isset($attribute, $value)){
                $collection->where($attribute, $value);
            }
        }

        return $collection;
    }

    protected function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => ['integer', 'min:2', 'max:50']
        ];
        \Validator::validate(request()->all(), $rules);

        $perPage = 15;
        if(request()->has('per_page')){
            $perPage = request()->per_page;
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $result = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginator = new LengthAwarePaginator($result, $collection->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);
        $paginator->appends(request()->all());

        return $paginator;
    }

    protected function transformData($data, ApiResource $transformer)
    {
        return new $transformer($data);
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
