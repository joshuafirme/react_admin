<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class InitialUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $users = [
            ['id' => 1, 'username'=>'superadmin', 'firstname' => 'Test','middlename' => '', 'lastname' => 'Super Admin', 'email' => 'superadmin@fhexpress.com', 'phone_number' => '09122222222', 'birthday' => '01/01/2000', 'gender' => 'male', 'password' => bcrypt('test1234'), 'role_id' => 1, 'agency_id' => 1],
            ['id' => 2, 'username'=>'administrator', 'firstname' => 'Test','middlename' => '', 'lastname' => 'Admin', 'email' => 'admin@fhexpress.com', 'phone_number' => '09122222222', 'birthday' => '01/01/2000', 'gender' => 'male', 'password' => bcrypt('test1234'), 'role_id' => 2, 'agency_id' => 1],
            ['id' => 3, 'username'=>'supervisor', 'firstname' => 'Test','middlename' => '', 'lastname' => 'supervisor', 'email' => 'supervisor@fhexpress.com', 'phone_number' => '09477277091', 'birthday' => '08/28/1994', 'gender' => 'male', 'password' => bcrypt('test1234'), 'role_id' => 3, 'agency_id' => 2],
            ['id' => 4, 'username'=>'staff', 'firstname' => 'test','middlename' => '', 'lastname' => 'staff', 'email' => 'staff@fhexpress.com', 'phone_number' => '09122222222', 'birthday' => '01/22/1993', 'gender' => 'female', 'password' => bcrypt('test1234'), 'role_id' => 4, 'agency_id' => 2],
            ['id' => 5, 'username'=>'test001', 'firstname' => '','middlename' => '', 'lastname' => 'staff', 'email' => 'test001@fhexpress.com', 'phone_number' => '09122222222', 'birthday' => '01/22/1993', 'gender' => 'male', 'password' => bcrypt('test1234'), 'role_id' => 4, 'agency_id' => 2],
        ];

        DB::table('users')->insert($users);
    }
}
