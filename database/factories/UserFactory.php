<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(User::class, function (Faker $faker) {

    //Since its same PW for all users, it's better to hash it once and add it to the return below. Since the return will loop for each number of users to be created
    $passwordHash = Hash::make('secreTe');
    $rememberToken = str_random(10);
    return [
        'name' => $faker->name,
        'role_id' => rand(1,4),
        'email' => $faker->unique()->safeEmail,
        'password' => $passwordHash,
        'remember_token' => $rememberToken #generate random string with lenght 10
        // 'created_at' => $faker->date('Y-m-d H:i:s'),
        // 'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
