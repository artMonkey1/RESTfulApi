<?php

namespace App\Http\Controllers\v1\Chief;

use App\Http\Controllers\v1\ApiController;
use App\Models\Chief;

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

        return $this->showCollection($chiefs);
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

        return $this->showOne($chief);
    }


}
