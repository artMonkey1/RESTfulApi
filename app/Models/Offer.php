<?php

namespace App\Models;

use App\Http\Resources\v1\OfferCollection;
use App\Http\Resources\v1\OfferResource;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public $transformer = OfferResource::class;
    public $collectionTransformer = OfferCollection::class;

    protected $fillable = [
        'sender_id',
        'sender_type',
        'recipient_id',
        'recipient_type',
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
