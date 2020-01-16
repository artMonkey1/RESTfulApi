<?php

namespace App\Http\Resources\v1;


use App\Interfaces\RevertsAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkerResource extends JsonResource
{

    public function toArray($request)

    {
        $this->resource->load('jobs');
        $workerId = $this->id;

        return [
            'identifier' =>(int) $this->id,
            'name' =>(string) $this->name,
            'email' =>(string) $this->email,
            'creationDate' => $this->created_at,
            'lastChange' => $this->updated_at,

            'links' => [
                'self' => route('workers.show', $this->id),
                'jobs' => [
                    'all' => route('workers.companies.index', $workerId),
                    'job' => $this->resource->jobs->map(function ($item) use ($workerId){
                                        return [
                                            'company' => route('companies.show', $item->id),
                                            'dismiss' => route('workers.companies.destroy', [$workerId, $item->id])
                                        ];
                                    })
                ],
            ],
        ];
    }
}
