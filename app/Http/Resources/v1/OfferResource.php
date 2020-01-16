<?php

namespace App\Http\Resources\v1;

use App\Interfaces\RevertsAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource implements RevertsAttributes
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->resource->load('sender');
        $this->resource->load('recipient');

        return [
            'identifier' => $this->id,
            'body' => $this->body,
            'position' => $this->position,
            'salary' => $this->salary,
            'creationDate' => $this->created_at,
            'lastChange' => $this->updated_at,
            'links' => [
                'sender' => $this->sender->path(),
                'recipient' => $this->recipient->path(),
            ],
        ];
    }

    public static function originalAttribute($field)
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'email' => 'email',
            'isVerified' => 'verified',
            'isAdmin' => 'admin',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at'
        ];

        return ($attributes[$field]) ? $attributes[$field] : null;
    }

    public static function transformedAttribute($field)
    {
        $attributes = [
            'id' =>'identifier',
            'name' =>'name',
            'email' =>'email',
            'verified' =>'isVerified',
            'admin' =>'isAdmin',
            'created_at' =>'creationDate',
            'updated_at' =>'lastChange',
        ];

        return isset($attributes[$field]) ? $attributes[$field] : null;
    }
}
