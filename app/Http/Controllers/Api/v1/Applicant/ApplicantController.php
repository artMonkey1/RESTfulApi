<?php

namespace App\Http\Controllers\Api\v1\Applicant;

use App\Http\Controllers\Api\v1\ApiController;
use App\Models\Applicant;
use App\Models\User;

class ApplicantController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials');
    }

    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $applicants = Applicant::where('applicant', User::APPLICANT_USER)->paginate();

        return $this->showCollection($applicants);
    }

    /**
     * Display the specified resource.
     *
     * @param Applicant $applicant
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Applicant $applicant)
    {
        return $this->showOne($applicant);
    }
}
