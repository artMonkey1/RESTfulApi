<?php


namespace App\Interfaces;

/**
 * Interface to provide accessing transformed attributes.
 * @package App\Interfaces
 */
interface RevertsAttributes
{
    public static function originalAttribute($field);

    public static function transformedAttribute($field);

}
