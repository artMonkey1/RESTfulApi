<?php

namespace App\Http\Controllers\Api\v1\Chief\Company;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\v1\CompanyResource;
use App\Models\Chief;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChiefCompanyController extends ApiController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('client.credentials')->only(['index']);

        $this->middleware('transform.input:'.CompanyResource::class)->only(['store', 'update']);

        $this->middleware('any.scope:manage-companies')->except(['index']);

        $this->middleware('can:acting-as-owner-of-company,chief,company')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Chief $chief
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Chief $chief)
    {
        $companies = $chief->companies()->paginate();

        return $this->showCollection($companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyRequest $request
     * @param User $chief
     * @return JsonResponse
     */
    public function store(CompanyRequest $request, User $chief)
    {
        $chief = Chief::find($chief->id);
        $company = $chief->companies()->create($request->validated());

        return $this->showOne($company, JsonResponse::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Chief $chief
     * @param Company $company
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Chief $chief, Company $company)
    {
        $rules = [
            'name' => ['unique:company,name,'.$company->id],
            'description' => ['min:10']
        ];

        $this->validate($request, $rules);

        if($request->has('name')){
            $company->name = $request->name;
        }

        if($request->has('description')){
            $company->description = $request->description;
        }

        if($company->isClean()){
            return $this->errorResponse('You need to specify a different fields to update', JsonResponse::HTTP_UNPROCESSABLE_ENTITY );
        }

        return $this->showOne($company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Chief $chief
     * @param Company $company
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Chief $chief, Company $company)
    {
        $company->delete();

        return $this->showOne($company, JsonResponse::HTTP_NO_CONTENT);
    }
}
