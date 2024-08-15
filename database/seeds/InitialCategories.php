<?php

use Illuminate\Database\Seeder;

class InitialCategories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['id' => 1, 'category_name' => 'Employment', 'category_description' => 'Employment'],
            ['id' => 2, 'category_name' => 'Crime', 'category_description' => 'Crime'],
            ['id' => 3, 'category_name' => 'Health', 'category_description' => 'Health'],
            ['id' => 4, 'category_name' => 'Counselling', 'category_description' => 'Counselling'],
            ['id' => 5, 'category_name' => 'Event', 'category_description' => 'Event'],
            ['id' => 6, 'category_name' => 'Calamities', 'category_description' => 'Calamities'],
            ['id' => 7, 'category_name' => 'Others', 'category_description' => 'Others'],
        ];

        DB::table('categories')->insert($categories);
    }
}
