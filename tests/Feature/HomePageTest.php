<?php

namespace Tests\Feature;

use Tests\BaseTest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends BaseTest
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHomepageWorks()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('#1');
    }
}
