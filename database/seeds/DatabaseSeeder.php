<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory('App\Models\User', 10)->create();
        factory('App\Models\Qrcode', 50)->create();
        factory('App\Models\Transaction', 50)->create();
        factory('App\Models\Account', 10)->create();    #Account need to be about 10 since each account belongs to a user
        factory('App\Models\AccountHistory', 10)->create();    #Each account has atleast one accountHistory (log)
    }
}
