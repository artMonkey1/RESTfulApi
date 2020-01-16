<?php

namespace App\Models;

use App\Http\Resources\v1\OfferResource;
use App\Http\Resources\v1\OffersCollection;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Offer
 *
 * @property int $id
 * @property int $sender_id
 * @property string $sender_type
 * @property int $recipient_id
 * @property string $recipient_type
 * @property string $body
 * @property string $position
 * @property string $salary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $recipient
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $sender
 * @property-write mixed $raw
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereRecipientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereRecipientType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereSenderType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Offer extends Model
{
    public $transformer = OfferResource::class;

    protected $fillable = [
        'sender_id',
        'sender_type',
        'recipient_id',
        'recipient_type',
        'body',
        'position',
        'salary',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function sender()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function recipient()
    {
        return $this->morphTo();
    }
}
