<?php

namespace App\Http\Controllers\Api\v1\Vacancy;

use App\Http\Controllers\Api\v1\ApiController;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->except('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vacancies = Vacancy::paginate();

        return $this->showCollection($vacancies);
    }

    /**
     * Display the specified resource.
     *
     * @param  Vacancy $vacancy
     * @return \Illuminate\Http\Response
     */
    public function show(Vacancy $vacancy)
    {
        return $this->showOne($vacancy);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Vacancy $vacancy
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function destroy(Vacancy $vacancy)
    {
        $this->allowedAdminAction();

        $vacancy->delete();

        return $this->showMessage('deleted');
    }
}
