<?php

namespace App\Http\Controllers\Api\v1\Applicant;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\OfferRequest;
use App\Http\Resources\v1\OfferResource;
use App\Models\Applicant;
use App\Models\Company;
use App\Models\Offer;
use App\Models\Vacancy;
use Illuminate\Http\JsonResponse;

class ApplicantOfferFromSelfController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('any.scope:manage-offers');

        $this->middleware('transform.input:'.OfferResource::class)->only(['sendToCompany', 'sendToVacancy']);

        $this->middleware('can:acting-as-applicant,applicant')->except(['show', 'destroy']);
        $this->middleware('can:manage-offer-from-self,applicant,offer')->only(['show', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Applicant $applicant
     * @return JsonResponse
     */
    public function index(Applicant $applicant)
    {
        if(!$applicant->offersFromSelf()->count()){
            return $this->errorResponse('The specified applicant does not have any offers from self', JsonResponse::HTTP_NOT_FOUND);
        }

        $offers = $applicant->offersFromSelf()->paginate();

        return $this->showCollection($offers);
    }

    /**
     * Display the specified resource.
     *
     * @param Applicant $applicant
     * @param Offer $offer
     * @return JsonResponse
     */
    public function show(Applicant $applicant, Offer $offer)
    {
        $applicant->offersFromSelf()->findOrFail($offer->sender->id);

        return $this->showOne($offer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OfferRequest $request
     * @param Applicant $applicant
     * @param Vacancy $vacancy
     * @return JsonResponse
     */
    public function sendToVacancy(OfferRequest $request,
                                  Applicant $applicant,
                                  Vacancy $vacancy)
    {
        if($applicant->vacancies()->find($vacancy->id)){
            return $this->errorResponse('Can\'t make offers on self vacancy', JsonResponse::HTTP_CONFLICT);
        }

        if($vacancy->author instanceof Applicant){
            $this->errorResponse('Can not send an offers to applicant\'s vacancy', JsonResponse::HTTP_CONFLICT);
        }

        $data = $this->getRecipientInfo($request, $vacancy);
        $offer = $applicant->offersFromSelf()->create($data);

        return $this->showOne($offer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OfferRequest $request
     * @param Applicant $applicant
     * @param Company $company
     * @return JsonResponse
     */
    public function sendToCompany(OfferRequest $request,
                                  Applicant $applicant,
                                  Company $company)
    {
        $data = $this->getRecipientInfo($request, $company);
        $offer = $applicant->offersFromSelf()->create($data);

        return $this->showOne($offer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Applicant $applicant
     * @param Offer $offer
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Applicant $applicant, Offer $offer)
    {
        $applicant->offersFromSelf()->findOrFail($offer->sender->id);

        $offer->delete();

        return $this->showMessage('', JsonResponse::HTTP_NO_CONTENT);
    }
}
