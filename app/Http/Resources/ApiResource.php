<?php


namespace App\Http\Resources;

use App\Interfaces\RevertsAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class ApiResource extends JsonResource implements RevertsAttributes
{
    public static function originalAttribute($field)
    {
        return $field;
    }

    public static function transformedAttribute($field)
    {
        return $field;
    }
}
