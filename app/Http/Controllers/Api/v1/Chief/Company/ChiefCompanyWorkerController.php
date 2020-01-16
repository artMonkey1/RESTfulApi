<?php

namespace App\Http\Controllers\Api\v1\Chief\Company;

use App\Http\Controllers\Api\v1\ApiController;
use App\Models\Chief;
use App\Models\Company;
use App\Models\Worker;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ChiefCompanyWorkerController extends ApiController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('any.scope:manage-companies');

        $this->middleware('can:acting-as-owner-of-company,chief,company');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Chief  $chief
     * @param  Company  $company
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Chief $chief, Company $company)
    {
        $workers = $company->workers()->paginate();

        return $this->showCollection($workers);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Chief  $chief
     * @param Company $company
     * @param Worker $worker
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chief $chief,
                            Company $company,
                            Worker $worker)
    {
        $company->workers()->findOrFail($worker->id);
        $company->workers()->detach($worker->id);

        return $this->showMessage('The specify worker has been dismiss!');
    }
}
