<?php

namespace App\Http\Controllers\Api\v1\Applicant;

use App\Http\Controllers\Api\v1\ApiController;
use App\Models\Applicant;
use App\Models\Offer;
use App\Models\Vacancy;
use App\Models\Worker;
use Illuminate\Http\JsonResponse;

class ApplicantVacancyOfferController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('any.scope:manage-offers');

        $this->middleware('can:acting-as-owner-of-vacancy,applicant,vacancy');
        $this->middleware('can:manage-offers-of-vacancy,applicant,vacancy,offer');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Applicant $applicant
     * @param Vacancy $vacancy
     * @return JsonResponse
     */
    public function index(Applicant $applicant, Vacancy $vacancy)
    {
        if(!$vacancy->offers()->count()){
            return $this->errorResponse('The vacancy does not have any offers', JsonResponse::HTTP_NOT_FOUND);
        }

        $offers = $vacancy->offers()->paginate();

        return $this->showCollection($offers);
    }

    /**
     * Display the specified resource.
     * @param Applicant $applicant
     * @param Vacancy $vacancy
     * @param Offer $offer
     * @return JsonResponse
     */
    public function show(Applicant $applicant, Vacancy $vacancy, Offer $offer)
    {
        return $this->showOne($offer);
    }

    /**
     * @param Applicant $applicant
     * @param Vacancy $vacancy
     * @param Offer $offer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function accept(Applicant $applicant, Vacancy $vacancy, Offer $offer)
    {
        $data = $this->getAcceptedInstanceData($offer->sender, $offer);
        $worker = Worker::find($applicant->id);

        $worker->jobs()->syncWithoutDetaching($data);

        $offer->delete();

        return $this->showMessage("The job has been accepted!");
    }

    /**
     * @param Applicant $applicant
     * @param Vacancy $vacancy
     * @param Offer $offer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function refuse(Applicant $applicant, Vacancy $vacancy, Offer $offer)
    {
        $offer->delete();

        return $this->showMessage('An Offer has been refused');
    }
}
