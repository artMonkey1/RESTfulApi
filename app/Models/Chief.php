<?php

namespace App\Models;

use App\Http\Resources\v1\ChiefResource;
use App\Scopes\ChiefScope;

/**
 * App\Models\Chief
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
 * @property-write mixed $raw
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chief newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chief newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chief query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chief whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chief whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chief whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chief whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chief whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chief wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chief whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chief whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chief whereVerificationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chief whereVerified($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 */
class Chief extends User
{
    public $transformer = ChiefResource::class;

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::addGlobalScope(new ChiefScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
