<?php


namespace App\Traits;


use App\Models\Offer;

trait Offers
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function offers()
    {
        return $this->morphMany(Offer::class, 'recipient');
    }
}
