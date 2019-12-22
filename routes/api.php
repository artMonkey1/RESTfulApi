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
Route::group(['namespace' => 'v1'], function() {

    /**
     * Users
     */
    Route::apiResource('users', 'User\UserController');

    /**
     * Workers
     */
    Route::apiResource('workers', 'Worker\WorkerController')->only('show', 'index');
    Route::apiResource('workers.companies', 'Worker\WorkerCompanyController')->except('update', 'store');
    Route::apiResource('chiefs.companies.workers', 'Worker\CompanyWorkerController')->except('update', 'store');

    /**
     * Chiefs
     */
    Route::apiResource('chiefs', 'Chief\ChiefController')->only('show', 'index');

    /**
     * Companies
     */
    Route::apiResource('companies', 'Company\CompanyController')->only('index', 'show');
    Route::apiResource('chiefs.companies', 'Company\ChiefCompanyController');
    Route::apiResource('workers.companies', 'Company\WorkerCompanyController')->except('update', 'store');

    /**
     * Offers
     */
    Route::apiResource('offers', 'Offer\OfferController')->only('index', 'show');
    Route::apiResource('chiefs.resume', 'Offer\CompanyOfferController')->except('show', 'store');
    Route::apiResource('chiefs.companies.resume', 'Offer\CompanyOfferController')->except('show', 'store');
    Route::apiResource('chiefs.companies.offers', 'Offer\CompanyOfferController')->except('show', 'update');
    Route::apiResource('workers.companies.resume', 'Offer\WorkerOfferController')->except('show', 'update');
    Route::apiResource('workers.companies.offers', 'Offer\WorkerOfferController')->except('show', 'store');

});
