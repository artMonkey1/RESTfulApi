<?php

namespace App\Http\Controllers\Api\v1\Applicant;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\VacancyRequest;
use App\Http\Resources\v1\VacancyResource;
use App\Models\Applicant;
use App\Models\Vacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApplicantVacancyController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
        $this->middleware('client.credentials')->only(['index']);

        $this->middleware('transform.input:'.VacancyResource::class)->only(['store', 'update']);


        $this->middleware('any.scope:manage-vacancies')->except(['index']);

        $this->middleware('can:acting-as-owner-vacancy,applicant,vacancy')->except(['index', 'store']);
        $this->middleware('can:acting-as-applicant,applicant')->only(['store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Applicant $applicant
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Applicant $applicant)
    {
        if(!$applicant->vacancies()->count()){
            return $this->errorResponse('The specified applicant does not have any vacancy', JsonResponse::HTTP_NOT_FOUND);
        }

        $vacancies = $applicant->vacancies()->paginate();

        return $this->showCollection($vacancies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VacancyRequest $request
     * @param Applicant $applicant
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(VacancyRequest $request, Applicant $applicant)
    {
        $vacancy = $applicant->vacancies()->create($request->validated());

        return $this->showOne($vacancy);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param VacancyRequest $request
     * @param Applicant $applicant
     * @param Vacancy $vacancy
     */
    public function update(VacancyRequest $request, Applicant $applicant, Vacancy $vacancy)
    {
        $vacancy = $applicant->vacancies()->findOrFail($vacancy->id);
        $vacancy->update($request->validated());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Applicant $applicant
     * @param Vacancy $vacancy
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Applicant $applicant, Vacancy $vacancy)
    {
        $vacancy = $applicant->vacancies()->findOrFail($vacancy->id);
        $vacancy->delete();

        return $this->showMessage('');
    }
}
