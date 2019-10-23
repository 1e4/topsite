<?php

namespace Tests\Feature;

use Tests\BaseTest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends BaseTest
{
    public function testRegisterPageRedirectsWhenLoggedIn(): void
    {
        $response = $this->get('register');

        $response->assertStatus(302);
    }

    public function testRegisterPageWorks(): void
    {
        auth()->logout();

        $response = $this->get('/register');

        $response->assertStatus(200);
    }
}
