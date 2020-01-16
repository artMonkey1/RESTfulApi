<?php

/**
 * Chiefs
 */
Route::apiResource('chiefs', 'Chief\ChiefController')->only(['show', 'index']);
Route::apiResource('chiefs.companies', 'Chief\Company\ChiefCompanyController')->except(['show']);
Route::apiResource('chiefs.companies.workers', 'Chief\Company\ChiefCompanyWorkerController')->only(['index', 'destroy']);
Route::apiResource('chiefs.companies.vacancies', 'Chief\Company\Vacancy\ChiefCompanyVacancyController')->except(['index', 'show']);

/**
 * Offers from a companies
 */
Route::apiResource('chiefs/{chief}/companies/{company}/from-self/offers', 'Chief\Company\ChiefCompanyOfferFromSelfController')->except(['update', 'store']);
Route::post('chiefs/{chief}/companies/{company}/applicants/{applicant}/send-offers', 'Chief\Company\ChiefCompanyOfferFromSelfController@sendToAppilcant');
Route::post('chiefs/{chief}/companies/{company}/vacancies/{vacancy}/send-offers', 'Chief\Company\ChiefCompanyOfferFromSelfController@sendToVacancy');
/**
 * Offers to a companies's vacancies
 */
Route::apiResource('chiefs.companies.vacancies.offers', 'Chief\Company\Vacancy\ChiefCompanyVacancyOfferController')->only(['index', 'show']);
Route::get('chiefs/{chief}/companies/{company}/vacancies/{vacancy}/offers/{offer}/accept', 'Chief\Company\Vacancy\ChiefCompanyVacancyOfferController@accept');
Route::get('chiefs/{chief}/companies/{company}/vacancies/{vacancy}/offers/{offer}/refuse', 'Chief\Company\Vacancy\ChiefCompanyVacancyOfferController@refuse');
/**
 * Offers to a companies
 */
Route::apiResource('chiefs.companies.offers', 'Chief\Company\ChiefCompanyOfferController')->only(['index', 'show']);
Route::get('chiefs/{chief}/companies/{company}/offers/{offer}/accept', 'Chief\Company\ChiefCompanyOfferController@accept');
Route::get('chiefs/{chief}/companies/{company}/offers/{offer}/refuse', 'Chief\Company\ChiefCompanyOfferController@refuse');

