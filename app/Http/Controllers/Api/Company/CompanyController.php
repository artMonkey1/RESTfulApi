<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Api\ApiController;
use App\Models\Company;
use Illuminate\Http\Request;

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

        return response()->json(['data' => $companies, 'code' => 200], 200);
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

        return response()->json(['data' => $company, 'code' => 200], 200);
    }

}
