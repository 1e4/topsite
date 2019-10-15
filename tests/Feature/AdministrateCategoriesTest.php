<?php

namespace Tests\Feature;

use App\Category;
use Tests\BaseTest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdministrateCategoriesTest extends BaseTest
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->category = Category::all()->random();
    }

    /**
     * Deleting a category removes it completely
     *
     * @return void
     */
    public function testDeletionRemovesCategory()
    {
        $this->delete("administration/category/{$this->category->id}");
        $this->assertDatabaseMissing('categories', [
            'id' => $this->category->id,
            'name' => $this->category->name,
        ]);
    }

    /**
     * Deleting a category redirects to general category administration page
     *
     * @return void
     */
    public function testDeletionRedirectsProperly()
    {
        $response = $this->delete("administration/category/{$this->category->id}");
        $response->assertRedirect('administration/category');
    }

    /**
     * Updating a category gives the category the correct values
     *
     * @return void
     */
    public function testUpdatingGivesCorrectData()
    {
        $this->putJson("administration/category/{$this->category->id}", [
            'name' => 'Stupid Games',
        ]);

        $this->category->refresh();

        $this->assertEquals($this->category->name, 'Stupid Games');
    }

    /**
     * Updating a category redirects back to the category management screen
     *
     * @return void
     */
    public function testUpdatingRedirectsProperly()
    {
        $response = $this->putJson("administration/category/{$this->category->id}", [
            'name' => 'P2W Games',
        ]);

        $response->assertRedirect("administration/category/{$this->category->id}");
    }

    /**
     * Creates a new category
     *
     * @return void
     */
    public function testCreatingCategory()
    {
        $oldCount = Category::count();
        $this->postJson("administration/category", [
            'name' => 'Ridiculous Games',
        ]);

        $newCount = Category::count();
        $this->assertTrue($oldCount < $newCount);
    }

    /**
     * Data Tables returns everything
     *
     * @return void
     */
    public function testDataTablesGivesAllData()
    {
        $response = $this->get("administration/category/datatables");
        $response->assertJsonCount(Category::count(), 'data');
    }
}
