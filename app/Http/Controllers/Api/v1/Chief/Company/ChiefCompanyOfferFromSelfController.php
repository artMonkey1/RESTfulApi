<?php

namespace App\Http\Controllers\Api\v1\Chief\Company;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\OfferRequest;
use App\Http\Resources\v1\OfferResource;
use App\Models\Applicant;
use App\Models\Chief;
use App\Models\Company;
use App\Models\Offer;
use App\Models\Vacancy;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChiefCompanyOfferFromSelfController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:'.OfferResource::class)->only(['sendToApplicant', 'sendToVacancy']);

        $this->middleware('any.scope:manage-offers');

        $this->middleware('can:acting-as-owner-of-company,chief,company')->except(['show', 'destroy']);
        $this->middleware('can:manage-offer-from-self,chief,company,offer')->only(['show', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @param Chief $chief
     * @param Company $company
     * @return JsonResponse|mixed
     */
    public function index(Chief $chief, Company $company)
    {
        if(!$company->offersFromSelf()->count()){
            return $this->errorResponse('The specified company does not have any offers', JsonResponse::HTTP_NOT_FOUND);
        }

        $offers = $company->offersFromSelf()->paginate();

        return  $this->showCollection($offers);
    }

    /**
     * Display the specified resource.
     * @param Chief $chief
     * @param Company $company
     * @param Offer $offer
     * @return JsonResponse
     */
    public function show(Chief $chief,
                         Company $company,
                         Offer $offer)
    {
        return $this->showOne($offer);
    }

    /**
     * @param OfferRequest $request
     * @param Chief $chief
     * @param Company $company
     * @param Applicant $applicant
     * @return JsonResponse
     */
    public function sendToApplicant(OfferRequest $request,
                                    Chief $chief,
                                    Company $company,
                                    Applicant $applicant)
    {
        $data = $this->getRecipientInfo($request, $applicant);

        $offer = $company->offersFromSelf()->create($data);

        return $this->showOne($offer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OfferRequest $request
     * @param Chief $chief
     * @param Company $company
     * @param Vacancy $vacancy
     * @return JsonResponse
     */
    public function sendToVacancy(OfferRequest $request,
                                 Chief $chief,
                                 Company $company,
                                 Vacancy $vacancy)
    {
        if($vacancy->author instanceof Company){
            return $this->errorResponse('Can not send an offers to companies\'s vacancy', JsonResponse::HTTP_CONFLICT);
        }

        $data = $this->getRecipientInfo($request, $vacancy);
        $offer = $company->offersFromSelf()->create($data);

        return $this->showOne($offer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Chief $chief
     * @param Company $company
     * @param Offer $offer
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Chief $chief,
                            Company $company,
                            Offer $offer)
    {
        $offer->delete();

        return $this->showMessage('An Offer has been deleted', JsonResponse::HTTP_NO_CONTENT);
    }

}
