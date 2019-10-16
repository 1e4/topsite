<?php

namespace Tests\Feature;

use Tests\BaseTest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \Auth;

class LoginTest extends BaseTest
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Auth::logout();
    }

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

    public function testLoginPageRedirectsWhenLoggedIn() {
        Auth::loginUsingId(1);
        $response = $this->get('/login');

        $response->assertStatus(302);
        Auth::logout();
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
        $res = $this->post('/login', [
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $res->assertStatus(302)
            ->assertRedirect('/home');
    }
}
