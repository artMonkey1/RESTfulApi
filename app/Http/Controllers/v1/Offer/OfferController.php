<?php

namespace App\Http\Controllers\v1\Offer;

use App\Http\Controllers\v1\ApiController;
use App\Models\Offer;

class OfferController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::all();

        return $this->showCollection($offers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        return $this->showOne($offer);
    }
}
