<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  \App\Http\Resources\BaseResource $transformer
     * @return mixed
     */
    public function handle($request, Closure $next, $transformer)
    {
        //Replacing an input to original field for table
        $transformedInputs = [];
        foreach ($request->request->all() as $field => $value){
            $transformedInputs[$transformer::originalAttribute($field)] = $value;
        }

        $request->replace($transformedInputs);

        //Replacing a fields from tables to transformed
        $response = $next($request);

        if(isset($response->exception) && $response->exception instanceof ValidationException){
            $data = $response->getData();
            $transformedErrors = [];

            foreach ($data->errors as $field => $error){
                $transformedField = $transformer::transformedAttribute($field);
                $transformedErrors[$transformedField] = str_replace($field, $transformedField, $error);
            }

            $data->errors = $transformedErrors;
            $response->setData();
        }
        return $response;
    }
}
