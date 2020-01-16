<?php

namespace App\Http\Controllers\Api\v1\Chief\Company;

use App\Http\Controllers\Api\v1\ApiController;
use App\Models\Chief;
use App\Models\Company;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChiefCompanyOfferController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('any.scope:manage-offers');

        $this->middleware('can:acting-as-owner-of-company,chief,company')->only(['index']);
        $this->middleware('can:manage-offer,chief,company,offer')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Chief $chief
     * @param Company $company
     * @return JsonResponse
     */
    public function index(Chief $chief, Company $company)
    {
        if(!$company->offers()->count()){
            return $this->errorResponse('The specified company does not have any offers', JsonResponse::HTTP_NOT_FOUND);
        }

        $offers = $company->offers()->paginate();

        return $this->showCollection($offers);
    }

    /**
     * Display the specified resource
     *
     * @param Chief $chief
     * @param Company $company
     * @param Offer $offer
     * @return JsonResponse
     */
    public function show(Chief $chief, Company $company, Offer $offer)
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
    public function accept(Chief $chief, Company $company, Offer $offer)
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
    public function refuse(Chief $chief, Company $company, Offer $offer)
    {
        $offer->delete();

        return $this->showMessage('An Offer has been refused');
    }
}
