<?php

namespace Tests\Feature;

use App\Category;
use Tests\BaseTest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryPageTest extends BaseTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->game = factory('App\Game')->create([
            'category_id' => Category::where('name', 'Space Games')->first()->id,
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCategoryWorks()
    {
        $response = $this->get('/category/space-games');

//        dd($this->game);

        $response->assertStatus(200);
        $response->assertSee($this->game->name);
    }
}
