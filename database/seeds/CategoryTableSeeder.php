<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Categories')->insert([
            'category_id' => null,
            'name' => str_random(10),
            'sort_index' => 1,
            'hide' => 0
        ]);
    }
}
