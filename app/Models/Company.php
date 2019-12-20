<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function chief()
    {
        return $this->belongsTo(Chief::class);
    }

    public function workers()
    {
        return $this->belongsToMany(Worker::class,'worker_company');
    }

    public function resume()
    {
        return $this->hasMany(Offer::class, 'recipient_id')->where('recipient_type', Company::class);
    }


    public function offers()
    {
        return $this->hasMany(Offer::class, 'sender_id')->where('sender_id', Company::class);
    }
}
