<?php

namespace App\Http\Controllers\Api\Offer;

use App\Http\Controllers\Api\ApiController;
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

        return response()->json(['data' => $offers, 'code' => 200], 200);
    }
}
