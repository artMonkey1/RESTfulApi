<?php

namespace App\Models;

use App\Http\Resources\v1\WorkerCollection;
use App\Http\Resources\v1\WorkerResource;

/**
 * App\Models\Worker
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $verified
 * @property string|null $verification_token
 * @property string $admin
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Company[] $companies
 * @property-read int|null $companies_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Offer[] $offers
 * @property-read int|null $offers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Offer[] $resume
 * @property-read int|null $resume_count
 * @property-write mixed $raw
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereVerificationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Worker whereVerified($value)
 * @mixin \Eloquent
 */
class Worker extends User
{
    public $transformer = WorkerResource::class;
    public $collectionTransformer = WorkerCollection::class;

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
        return $this->hasMany(Offer::class, 'recipient_id')->where('recipient_type', App\Models\Worker::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resume()
    {
        return $this->hasMany(Offer::class, 'sender_id')->where('sender_id', App\Models\Worker::class);
    }


}
