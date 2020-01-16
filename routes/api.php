<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api\v1', 'prefix' => 'v1'], function() {

    /**
     * Auth routs
     */
    include_once 'auth.php';

    /**
     * Chiefs routs
     */
    include_once 'chiefs.php';

    /**
     * Applicants routs
     */
    include_once 'applicants.php';

    /**
     * Users
     */
    Route::apiResource('users', 'User\UserController')->except(['store']);

    /**
     * Vacancies
     */
    Route::apiResource('vacancies', 'Vacancy\VacancyController')->only(['index', 'show']);

    /**
     * Companies
     */
    Route::apiResource('companies', 'Company\CompanyController')->only(['index', 'show']);
    Route::apiResource('companies.vacancies', 'Company\CompanyVacancyController')->only(['index']);

    /**
     * Workers
     */
    Route::apiResource('workers', 'Worker\WorkerController')->only(['show', 'index']);
    Route::apiResource('workers.companies', 'Worker\WorkerCompanyController')->only(['index', 'destroy']);
    /**
     * Offers
     */
    Route::apiResource('offers', 'Offer\OfferController')->only(['index', 'show']);
});

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken')->name('passport.token');
