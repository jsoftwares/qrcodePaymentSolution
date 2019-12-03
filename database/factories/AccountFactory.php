<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Account;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {

    $withdrawal_method = array('Bank', 'PayPal', 'Stripe', 'Paystack');
    #here we user pluck bcos all() returns an object & randomElement() expects an array
    $usersIds = App\Models\User::pluck('id')->all();

    return [

        'user_id' => $faker->unique()->randomElement($usersIds), #unique bcos a user can only have one account
        'balance' => $faker->numberBetween(200, 5000),
        'total_credit' => $faker->numberBetween(500, 10000),
        'total_debit' => $faker->numberBetween(0, 500),
        'withdrawal_method' => $withdrawal_method[rand(0,3)],
        'payment_email' => $faker->email,
        'bank_name' => $faker->word,
        'bank_account' => $faker->bankAccountNumber,
        'account_name' => $faker->name,
        'bank_branch' => $faker->state,
        'applied_for_payout' => $faker->numberBetween(0,1),
        'paid' => $faker->numberBetween(0,1),
        // 'last_date_applied' => $faker->word,
        // 'last_date_paid' => $faker->word,
        'country' => $faker->country,
        'other_details' => $faker->paragraph(4, true), #4 specifies the number of sentences to be in the paragraph. True make it shuffle between 1-4 sentences
        // 'deleted_at' => $faker->date('Y-m-d H:i:s'),
        // 'created_at' => $faker->date('Y-m-d H:i:s'),
        // 'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
