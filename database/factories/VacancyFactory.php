<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Vacancy;
use Faker\Generator as Faker;

$factory->define(Vacancy::class, function (Faker $faker) {

    $company = \App\Models\Company::all()->random();
    $applicant = \App\Models\Applicant::where('applicant', \App\Models\User::APPLICANT_USER)->get();

    $applicant = $applicant->random();
    $author = $faker->randomElement([$company, $applicant]);

    return [
        'body' => $faker->paragraph,
        'author_id' => $author->id,
        'author_type' => get_class($author),
    ];
});
