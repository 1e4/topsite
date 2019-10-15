<?php

namespace Tests;

use App\User;
use \Auth;

class BaseTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $admin = factory(User::class)->create([
            'is_admin' => true,
        ]);
        Auth::loginUsingId($admin->id);

        $this->artisan('db:seed', ['--class' => 'SettingsSeeder']);
        foreach (config('categories') as $categoryName) {
            $category = new \App\Category();
            $category->name = $categoryName;
            $category->save();
        }
    }
}
