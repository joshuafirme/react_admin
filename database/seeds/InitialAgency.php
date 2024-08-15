<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InitialAgency extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agencies = [
            ['id' => 1, 'agency_name' => 'Test 1', 'agency_description' => 'Test 1', 'agency_type' => 'Test 1', 'date_registered' => Carbon::now()],
            ['id' => 2, 'agency_name' => 'Test 2', 'agency_description' => 'Test 2', 'agency_type' => 'Test 2', 'date_registered' => Carbon::now()],
            ['id' => 3, 'agency_name' => 'Test 3', 'agency_description' => 'Test 3', 'agency_type' => 'Test 3', 'date_registered' => Carbon::now()],
            ['id' => 4, 'agency_name' => 'Test 4', 'agency_description' => 'Test 4', 'agency_type' => 'Test 4', 'date_registered' => Carbon::now()],
            ['id' => 5, 'agency_name' => 'Test 5', 'agency_description' => 'Test 5', 'agency_type' => 'Test 5', 'date_registered' => Carbon::now()],
            ['id' => 6, 'agency_name' => 'Test 6', 'agency_description' => 'Test 6', 'agency_type' => 'Test 6', 'date_registered' => Carbon::now()],
        ];

        DB::table('agencies')->insert($agencies);
    }
}
