<?php

namespace App\Http\Controllers\Api\v1\Company;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\v1\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials');
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        $companies = Company::paginate();

        return $this->showCollection($companies);
    }

    /**
     * Display the specified resource.
     *
     * @param Company $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Company $company)
    {
        return $this->showOne($company);
    }
}
