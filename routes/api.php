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
Route::group(['namespace' => 'Api'], function() {

    /**
     * Users
     */
    Route::apiResource('users', 'User\UserController');

    /**
     * Workers
     */
    Route::apiResource('workers', 'Worker\WorkerController')->only('show', 'index');

    /**
     * Chiefs
     */
    Route::apiResource('chiefs', 'Chief\ChiefController')->only('show', 'index');

    /**
     * Offers
     */
    Route::apiResource('offers', 'Offer\OfferController')->only('index');

    /**
     * Companies
     */
    Route::apiResource('companies', 'Company\CompanyController')->only('index', 'show');
});
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
