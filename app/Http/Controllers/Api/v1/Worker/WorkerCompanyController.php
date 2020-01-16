<?php

namespace App\Http\Controllers\Api\v1\Worker;

use App\Http\Controllers\Api\v1\ApiController;
use App\Models\Company;
use App\Models\Worker;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class WorkerCompanyController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('any.scope:manage-jobs');

        $this->middleware('can:manage-jobs,worker');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Worker $worker
     * @return \Illuminate\Http\Response
     */
    public function index(Worker $worker)
    {
        $companies = $worker->jobs()->paginate();

        return $this->showCollection($companies);
    }

    /**
     * Remove the specified resource from storage
     *
     * @param Worker $worker
     * @param Company $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Worker $worker, Company $company)
    {
        $worker->jobs()->findOrFail($company->id);
        $worker->jobs()->detach($company->id);

        return $this->showMessage('', JsonResponse::HTTP_NO_CONTENT);
    }
}
