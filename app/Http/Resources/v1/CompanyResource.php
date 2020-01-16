<?php

namespace App\Http\Resources\v1;

use App\Interfaces\RevertsAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource implements RevertsAttributes
{
    /**
     * Transform the resource into an array.
     *
     * @param  /App/Models/Worker  $instance
     * @return array
     */
    public function toArray($request)
    {
        return [
            'identifier' =>(int) $this->id,
            'name' =>(string) $this->name,
            'description' =>(string) $this->email,
            'chiefIdentifier' =>(int) $this->chief_id,
            'creationDate' =>(string)$this->created_at,
            'lastChange' =>(string)$this->updated_at,
            'links' => [
                'self' => route('companies.show', $this->id),
                'chief' => route('chiefs.show', $this->chief_id),
                'companies.vacancies' => route('companies.vacancies.index', $this->id),
                'auth' => [
                    'chiefs' => [
                        'chiefs.companies.offers' => route('chiefs.companies.offers.index', [$this->chief_id, $this->id]),
                        //'chiefs.companies.from-self.offers' => route('offers.index', [$this->chief_id, $this->id]),
                        'chiefs.companies.workers' => route('chiefs.companies.workers.index', [$this->chief_id, $this->id]),
                    ],
                ],
            ],
        ];
    }

    public static function originalAttribute($field)
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'email' => 'email',
            'chiefIdentifier' => 'chief_id',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at'
        ];

        return ($attributes[$field]) ? $attributes[$field] : null;
    }

    public static function transformedAttribute($field)
    {
        $attributes = [
            'id' =>'identifier',
            'name' =>'name',
            'email' =>'email',
            'chief_id' => 'chiefIdentifier',
            'created_at' =>'creationDate',
            'updated_at' =>'lastChange',
        ];

        return isset($attributes[$field]) ? $attributes[$field] : null;
    }
}
