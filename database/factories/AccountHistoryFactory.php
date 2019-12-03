<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AccountHistory;
use Faker\Generator as Faker;

$factory->define(AccountHistory::class, function (Faker $faker) {

    return [
        'account_id' => function(){return App\Models\Account::all()->random();},
        'user_id' => function(){return App\Models\User::all()->random();},
        'message' => $faker->paragraph(2, true),
        // 'deleted_at' => $faker->date('Y-m-d H:i:s'),
        // 'created_at' => $faker->date('Y-m-d H:i:s'),
        // 'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
