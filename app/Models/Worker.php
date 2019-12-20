<?php

namespace App\Models;

class Worker extends User
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'worker_company');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers()
    {
        return $this->hasMany(Offer::class, 'recipient_id')->where('recipient_type', Worker::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resume()
    {
        return $this->hasMany(Offer::class, 'sender_id')->where('sender_id', Worker::class);
    }


}
