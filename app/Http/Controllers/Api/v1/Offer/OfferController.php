<?php

namespace App\Http\Controllers\Api\v1\Offer;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Resources\v1\CompanyResource;
use App\Models\Offer;

class OfferController extends ApiController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function index()
    {
        $this->allowedAdminAction();

        $offers = Offer::paginate();

        return $this->showCollection($offers);
    }

    /**
     * Display the specified resource.
     *
     * @param Offer $offer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function show(Offer $offer)
    {
        $this->allowedAdminAction();

        return $this->showOne($offer);
    }
}
