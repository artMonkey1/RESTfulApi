<?php

namespace App\Http\Controllers\Api\v1\Chief\Company\Vacancy;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\UpdateVacancyRequest;
use App\Http\Requests\VacancyRequest;
use App\Http\Resources\v1\VacancyResource;
use App\Models\Chief;
use App\Models\Company;
use App\Models\Vacancy;

class ChiefCompanyVacancyController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:'.VacancyResource::class)->only(['store', 'update']);

        $this->middleware('any.scope:manage-vacancies');

        $this->middleware('can:acting-as-owner-of-company,chief,company')->only('store');
        $this->middleware('can:acting-as-owner-of-vacancy,chief,company,vacancy')->except('store');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param VacancyRequest $request
     * @param Chief $chief
     * @param Company $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(VacancyRequest $request, Chief $chief, Company $company)
    {
        $vacancy = $company->vacancies()->create($request->validated());

        return $this->showOne($vacancy);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVacancyRequest $request
     * @param Chief $chief
     * @param Company $company
     * @param Vacancy $vacancy
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateVacancyRequest $request, Chief $chief, Company $company, Vacancy $vacancy)
    {
        $vacancy->update($request->validated());

        return $this->showOne($vacancy);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Chief $chief
     * @param Company $company
     * @param Vacancy $vacancy
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Chief $chief, Company $company, Vacancy $vacancy)
    {
        $vacancy->delete();

        return $this->showMessage('Vacancy has been deleted');
    }
}
