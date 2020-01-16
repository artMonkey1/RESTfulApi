<?php


namespace App\Traits;


use App\Models\Offer;

trait SelfOffers
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function offersFromSelf()
    {
        return $this->morphMany(Offer::class, 'sender');
    }
}
