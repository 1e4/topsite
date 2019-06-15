<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginPageLoads()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testLoginFailsOnEmptyFields()
    {
        $res = $this->post('/login');

        $res->assertStatus(302);
    }

    public function testLoginFailsWithInvalidEmail()
    {
        $res = $this->post('/login', [
            'email' => 'notanemail'
        ]);

        $res->assertStatus(302);
    }

    public function testLoginSucceeds()
    {
        $user = new User();
        $user->email = 'test@test.com';
        $user->name = 'Test';
        $user->password = bcrypt('password');
        $user->email_verified_at = Carbon::now();
        $user->save();

        $res = $this->post('/login', [
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $res->assertStatus(302)
            ->assertRedirect('/home');
    }
}
