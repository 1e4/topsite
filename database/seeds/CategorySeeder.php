<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(config('categories') as $categoryName)
        {
            $category = new \App\Category();
            $category->name = $categoryName;
            $category->save();
        }
    }
}
