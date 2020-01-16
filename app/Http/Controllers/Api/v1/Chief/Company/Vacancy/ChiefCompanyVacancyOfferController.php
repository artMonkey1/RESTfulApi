<?php

namespace App\Http\Controllers\Api\v1\Chief\Company\Vacancy;

use App\Http\Controllers\Api\v1\ApiController;
use App\Models\Chief;
use App\Models\Company;
use App\Models\Offer;
use App\Models\Vacancy;
use Illuminate\Http\JsonResponse;

class ChiefCompanyVacancyOfferController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('any.scope:manage-offers');

        $this->middleware('can:acting-as-owner-of-vacancy,chief,company,vacancy')->only(['index']);
        $this->middleware('can:manage-offers-of-vacancy,chief,company,vacancy,offer')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Chief $chief
     * @param Company $company
     * @param Vacancy $vacancy
     * @return JsonResponse|mixed
     */
    public function index(Chief $chief, Company $company, Vacancy $vacancy)
    {
        if(!$vacancy->offers()->count()){
            return $this->errorResponse('The specified vacancy does not have any offers', JsonResponse::HTTP_NOT_FOUND);
        }

        $offers = $vacancy->offers()->paginate();

        return $this->showCollection($offers);
    }

    /**
     * Display the specified resource.
     *
     * @param Chief $chief
     * @param Company $company
     * @param Vacancy $vacancy
     * @param Offer $offer
     * @return JsonResponse
     */
    public function show(Chief $chief, Company $company, Vacancy $vacancy, Offer $offer)
    {
        return $this->showOne($offer);
    }

    /**
     * @param Chief $chief
     * @param Company $company
     * @param Offer $offer
     * @return JsonResponse
     * @throws \Exception
     */
    public function accept(Chief $chief, Company $company, Vacancy $vacancy, Offer $offer)
    {
        $worker = $offer->sender;

        $data = $this->getAcceptedInstanceData($worker, $offer);

        $company->workers()->syncWithoutDetaching($data);
        $offer->delete();

        return $this->showMessage("A worker $worker->name has been accepted!");
    }

    /**
     * @param Chief $chief
     * @param Company $company
     * @param Offer $offer
     * @return JsonResponse
     * @throws \Exception
     */
    public function refuse(Chief $chief, Company $company, Vacancy $vacancy, Offer $offer)
    {
        $offer->delete();

        return $this->showMessage('An Offer has been refused');
    }
}
