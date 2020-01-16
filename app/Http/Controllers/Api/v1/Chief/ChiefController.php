<?php

namespace App\Http\Controllers\Api\v1\Chief;

use App\Http\Controllers\Api\v1\ApiController;
use App\Models\Chief;

class ChiefController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chiefs = Chief::has('companies')->paginate();

        return $this->showCollection($chiefs);
    }

    /**
     * Display the specified resource.
     * @param Chief $chief
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Chief $chief)
    {
        return $this->showOne($chief);
    }
}
