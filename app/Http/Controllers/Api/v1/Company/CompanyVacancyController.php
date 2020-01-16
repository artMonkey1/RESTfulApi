<?php


namespace App\Http\Controllers\Api\v1\Company;


use App\Http\Controllers\Api\v1\ApiController;
use App\Models\Company;
use Illuminate\Http\JsonResponse;

class CompanyVacancyController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Company $company
     * @return JsonResponse|mixed
     */
    public function index(Company $company)
    {
        if(!$company->vacancies()->count()){
            return $this->errorResponse('The specified company does not have any vacancy', JsonResponse::HTTP_NOT_FOUND);
        }

        $vacancies = $company->vacancies()->paginate();

        return $this->showCollection($vacancies);
    }
}
