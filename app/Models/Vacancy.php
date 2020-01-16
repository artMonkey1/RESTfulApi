<?php

namespace App\Models;

use App\Http\Resources\v1\VacancyResource;
use App\Traits\Offers;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use Offers;

    public $transformer = VacancyResource::class;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function author()
    {
        return $this->morphTo();
    }

    public function path()
    {
        return route('vacancies.show', $this->id);
    }
}
