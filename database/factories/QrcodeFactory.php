<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Qrcode;
use Faker\Generator as Faker;

$factory->define(Qrcode::class, function (Faker $faker) {

    //To let factory know how many of such instance to create, we did that in DatabaseSeeder.php

    return [
        'user_id' => function(){return App\Models\User::all()->random();}, #picks a user from already generated users randomly
        'company_name' => $faker->sentence(rand(4,8), true), //random sentence btw 4-8 words. true makes it string otherwsie it will be an array of words
        'website' => $faker->url,
        'product_name' => $faker->name,
        'product_url' => $faker->url,
        'amount' => $faker->numberBetween(5000, 21000),
        'callback_url' => $faker->url,
        'qrcode_path' => 'qrcodes_img/'.rand(1,2).'.png', //use qrcode with IDs 1 or 2 randamly
        'status' => rand(0,1),
        // 'deleted_at' => $faker->date('Y-m-d H:i:s'),
        // 'created_at' => $faker->date('Y-m-d H:i:s'),
        // 'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
