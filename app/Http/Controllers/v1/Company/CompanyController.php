<?php

namespace App\Http\Controllers\v1\Company;

use App\Http\Controllers\v1\ApiController;
use App\Models\Company;

class CompanyController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();

        return $this->showCollection($companies);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::findOrFail($id);

        return $this->showOne($company);
    }

}
