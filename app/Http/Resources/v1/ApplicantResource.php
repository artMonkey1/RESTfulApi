<?php

namespace App\Http\Resources\v1;

use App\Interfaces\RevertsAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'identifier' =>(int) $this->id,
            'name' =>(string) $this-> name,
            'email' =>(string) $this->email,
            'creationDate' => $this->created_at,
            'lastChange' => $this->updated_at,

            'links' => [
                'self' => route('applicants.show', $this->id),
                'vacancies' => route('applicants.vacancies.index', $this->id),
            ],
        ];
    }
}
