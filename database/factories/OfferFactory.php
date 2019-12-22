<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Offer;
use Faker\Generator as Faker;

$factory->define(Offer::class, function (Faker $faker) {
    $company = \App\Models\Company::all()->random();
    $worker = \App\Models\Worker::all()->except($company->chief->id)->random();

    return [
            'sender_id' => $sender = $faker->randomElement([$company, $worker]),
            'sender_type' => get_class($sender),
            'recipient_id' => ($sender == $worker) ? $recipient = $company : $recipient = $worker,
            'recipient_type' => get_class($recipient),
            'body' => $faker->paragraph(1),
            'position' => $faker->word(),
            'salary' => $faker->numberBetween(1000, 100000)
    ];
});
