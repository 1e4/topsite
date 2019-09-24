<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Test account
        $user = new \App\User();
        $user->name = 'Administrator';
        $user->password = Hash::make('password');
        $user->email = 'test@test.com';
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->is_admin = true;
        $user->save();
    }
}
