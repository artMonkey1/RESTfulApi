<?php

/**
 * Applicant
 */
Route::apiResource('applicants', 'Applicant\ApplicantController')->only(['index', 'show']);
Route::apiResource('applicants.vacancies', 'Applicant\ApplicantVacancyController');

/**
 * Offers from an applicants
 */
Route::apiResource('applicants.from-self/offers', 'Applicant\ApplicantOfferFromSelfController')->except(['update', 'store']);
Route::post('applicants/{applicant}/companies/{company}/send-offers', 'Applicant\ApplicantOfferFromSelfController@sendToCompany');
Route::post('applicants/{applicant}/vacancies/{vacancy}/send-offers', 'Applicant\ApplicantOfferFromSelfController@sendToVacancy');
/**
 * Applicants's offers
 */
Route::apiResource('applicants.offers', 'Applicant\ApplicantOfferController')->only(['index', 'show']);
Route::get('applicants/{applicant}/offers/{offer}/accept', 'Applicant\ApplicantOfferController@accept');
Route::get('applicants/{applicant}/offers/{offer}/refuse', 'Applicant\ApplicantOfferController@refuse');
/**
 * Offers to an applicants's vacancies
 */
Route::apiResource('applicants.vacancies.offers', 'Applicant\ApplicantVacancyOfferController')->only(['index', 'show']);
Route::get('applicants/{applicant}/vacancies/{vacancy}/offers/{offer}/accept', 'Applicant\ApplicantVacancyOfferController@accept');
Route::get('applicants/{applicant}/vacancies/{vacancy}/offers/{offer}/refuse', 'Applicant\ApplicantVacancyOfferController@refuse');

