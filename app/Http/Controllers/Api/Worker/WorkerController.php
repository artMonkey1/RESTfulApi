<?php

namespace App\Http\Controllers\Api\Worker;

use App\Http\Controllers\Api\ApiController;
use App\Models\Worker;
use Illuminate\Http\Request;

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

        return response()->json(['data' => $workers, 'code' => 200], 200);
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

        return response()->json(['data' => $worker, 'code' => 200], 200);
    }
}
