<?php

namespace App\Http\Resources\v1;

use App\Interfaces\RevertsAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource implements RevertsAttributes
{
    /**
     * Transform the resource into an array.
     *
     * @param  /App/Models/User   $instance
     * @return array
     */
    public function toArray($request)
    {
        return [
            'identifier' =>(int) $this->id,
            'name' =>(string) $this-> name,
            'email' =>(string) $this->email,
            'isVerified' =>(int) $this->verified,
            'isAdmin' =>($this->admin === true),
            'creationDate' => $this->created_at,
            'lastChange' => $this->updated_at,

            'links' => [
                'self' => route('users.show', $this->id),
                'worker' => route('workers.show', $this->id),
                'chief' => route('chiefs.show', $this->id),
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
