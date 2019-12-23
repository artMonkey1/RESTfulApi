<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\ApiResource;

class UserResource extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request   $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
