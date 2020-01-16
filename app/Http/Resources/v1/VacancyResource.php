<?php

namespace App\Http\Resources\v1;

use App\Interfaces\RevertsAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class VacancyResource extends JsonResource implements RevertsAttributes
{
    /**
     * Transform the resource into an array.
     *
     * @param  /App/Models/Chief $request
     * @return array
     */
    public function toArray($request)
    {
        $this->resource->load('author');
        return [
            'identifier' =>(int) $this->resource->id,
            'text' =>(string)  $this->resource->body,
            'creationDate' =>(string) $this->resource->created_at,
            'lastChange' =>(string) $this->resource->updated_at,
            'links' => [
                'author' => $this->resource->author->path(),
            ]
        ];
    }

    public static function originalAttribute($field)
    {
        $attributes = [
            'identifier' => 'id',
            'text' => 'body',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at'
        ];

        return ($attributes[$field]) ? $attributes[$field] : null;
    }

    public static function transformedAttribute($field)
    {
        $attributes = [
            'id' =>'identifier',
            'body' =>'text',
            'created_at' =>'creationDate',
            'updated_at' =>'lastChange',
        ];

        return isset($attributes[$field]) ? $attributes[$field] : null;
    }
}
