<?php

namespace App\Http\Controllers\v1\Worker;

use App\Http\Controllers\v1\ApiController;
use App\Models\Worker;

class WorkerController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workers = Worker::all();

        return $this->showCollection($workers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $worker = Worker::findOrFail($id);

        return $this->showOne($worker);
    }
}
