<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'sender_id',
        'recipient_id',
        'body',
        'position',
        'salary',
    ];

    public function sender()
    {
        return $this->belongsTo($this->sender_type);
    }

    public function recipient()
    {
        return $this->belongsTo($this->recipient_type);
    }
}
