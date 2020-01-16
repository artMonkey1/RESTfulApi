<?php

namespace App\Http\Resources\v1;

use App\Interfaces\RevertsAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class ChiefResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  /App/Models/Chief $request
     * @return array
     */
    public function toArray($request)
    {
        $this->resource->load('companies');

        return [
            'identifier' =>(int) $this->resource->id,
            'name' =>(string)  $this->resource->name,
            'email' =>(string) $this->resource->email,
            'creationDate' => $this->resource->created_at,
            'lastChange' => $this->resource->updated_at,
            'links' => [
                'self' => route('chiefs.show', $this->id),
                'have' =>
                    $this->resource->companies->map(function ($item){
                        return [
                            'company' => route('companies.show', $item->id)
                        ];
                    })

            ],
        ];
    }
}
