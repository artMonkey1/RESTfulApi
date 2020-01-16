<?php

namespace App\Models;

use App\Http\Resources\v1\CompanyResource;
use App\Traits\Offerable;
use EloquentFilter\Filterable;
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Offer[] $offersForCompany
 * @property-read int|null $offers_for_company_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Offer[] $offersFromCompany
 * @property-read int|null $offers_from_company_count
 */
class Company extends Model
{
    use Offerable;

    public $transformer = CompanyResource::class;

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chief()
    {
        return $this->belongsTo(Chief::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workers()
    {
        return $this->belongsToMany(Worker::class, 'worker_company')->withPivot('position', 'salary');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function vacancies()
    {
        return $this->morphMany(Vacancy::class, 'author');
    }

    public function path()
    {
        return route('companies.show', $this->id);
    }
}
