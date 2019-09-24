<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);

        foreach(config('categories') as $categoryName)
        {
            $category = new \App\Category();
            $category->name = $categoryName;
            $category->save();
        }

        factory(\App\Game::class, 100)->create();
    }
}
