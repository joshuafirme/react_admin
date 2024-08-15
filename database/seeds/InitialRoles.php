<?php

use Illuminate\Database\Seeder;

class InitialRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['id' => 1, 'role_name' => 'SuperAdmin', 'role_description' => 'Super Administrator'],
            ['id' => 2, 'role_name' => 'Admin', 'role_description' => 'Administrator'],
            ['id' => 3, 'role_name' => 'Customer', 'role_description' => 'Customers'],
            ['id' => 4, 'role_name' => 'Agency', 'role_description' => 'Agency'],
        ];

        DB::table('roles')->insert($roles);
    }
}
