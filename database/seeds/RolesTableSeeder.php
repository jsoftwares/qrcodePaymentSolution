<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Since we want real roles and not dummy data for roles, we use Seeder in creating them as oppose to factory
        Role::create(['name' => 'Administrator']);
        Role::create(['name' => 'Moderator']);
        Role::create(['name' => 'Merchant']);
        Role::create(['name' => 'Buyer']);
    }
}
