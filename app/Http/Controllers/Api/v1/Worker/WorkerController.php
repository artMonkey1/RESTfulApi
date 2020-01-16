<?php

namespace App\Http\Controllers\Api\v1\Worker;

use App\Http\Controllers\Api\v1\ApiController;
use App\Models\Worker;

class WorkerController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workers = Worker::has('jobs')->paginate();

        return $this->showCollection($workers);
    }

    /**
     * Display the specified resource.
     *
     * @param Worker $worker
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Worker $worker)
    {
        return $this->showOne($worker);
    }
}
