<?php

namespace Tests\Unit;

use App\Services\CategoryService;
use Tests\BaseTest;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryServiceTest extends BaseTest
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->categoryService = $this->app->make(CategoryService::class);
    }

    /**
     * Makes sure the category array appears correctly
     *
     * @return void
     */
    public function testCategoryArray()
    {
        $categories = $this->categoryService->buildSelectArray();
        $this->assertTrue(is_array($categories));
    }
}
