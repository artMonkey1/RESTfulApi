<?php

namespace App\Http\Controllers\Api\Chief;

use App\Http\Controllers\Api\ApiController;
use App\Models\Chief;
use Illuminate\Http\Request;

class ChiefController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chiefs = Chief::has('companies')->get();

        return response()->json(['data' => $chiefs, 'code' => 200], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chief = Chief::has('companies')->findOrFail($id);

        return response()->json(['data' => $chief, 'code' => 200], 200);
    }


}
