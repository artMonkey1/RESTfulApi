<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Offer;
use Faker\Generator as Faker;

$factory->define(Offer::class, function (Faker $faker) {

    //Getting an instances for sender and recipient
    $company = \App\Models\Company::all()->random();
    $applicant = \App\Models\Applicant::where('applicant', \App\Models\User::APPLICANT_USER)->get();
    $applicant = $applicant->random();

    //Getting a sender
    $sender = $faker->randomElement([$company, $applicant]);
    $vacancy = \App\Models\Vacancy::all()->except(['author_type' => get_class($sender)])->random();

    //Getting a recipient
    if($sender == $applicant){
        $recipient = $faker->randomElement([$company, $vacancy]);
    }else{
        $recipient = $faker->randomElement([$applicant, $vacancy]);
    }

    return [
            'sender_id' => $sender->id,
            'sender_type' => get_class($sender),
            'recipient_id' => $recipient->id,
            'recipient_type' => get_class($recipient),
            'body' => $faker->paragraph(1),
            'position' => $faker->word(),
            'salary' => $faker->numberBetween(1000, 100000)
    ];
});
