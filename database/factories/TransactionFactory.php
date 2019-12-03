<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {

    // We create an array to hold different status value, then make status => random content on the array
    $status = array('Completed', 'Initiated', 'Failed');

    return [
        'user_id' => function(){return App\Models\User::all()->random();},
        'qrcode_id' => function(){return App\Models\Qrcode::all()->random();},
        'amount' => $faker->numberBetween(5000, 21000),
        'payment_method' => 'Paystack/'. $faker->creditCardType,
        'qrcode_owner_id' => function(){return App\Models\User::all()->random();},
        'status' => $status[rand(1,2)]
        // 'message' => $faker->text,
        // 'created_at' => $faker->date('Y-m-d H:i:s'),
        // 'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
