<?php

namespace App\Models;

use App\Http\Resources\v1\CompanyCollection;
use App\Http\Resources\v1\CompanyResource;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Company
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $chief_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Chief $chief
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Offer[] $offers
 * @property-read int|null $offers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Offer[] $resume
 * @property-read int|null $resume_count
 * @property-write mixed $raw
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Worker[] $workers
 * @property-read int|null $workers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereChiefId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Company extends Model
{
    public $transformer = CompanyResource::class;
    public $collectionTransformer = CompanyCollection::class;

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
        return $this->hasMany(Offer::class, 'recipient_id')->where('recipient_type', App\Models\Company::class);
    }


    public function offers()
    {
        return $this->hasMany(Offer::class, 'sender_id')->where('sender_id', App\Models\Company::class);
    }
}
