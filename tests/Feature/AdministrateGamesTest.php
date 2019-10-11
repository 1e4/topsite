<?php

namespace Tests\Feature;

use App\Category;
use App\Game;
use App\Jobs\SendGameApprovalHookToDiscord;
use Tests\BaseTest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;

class AdministrateGamesTest extends BaseTest
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->game = factory('App\Game')->create();
    }

    /**
     * Confirm the job to send approval to Discord is fired off
     *
     * @return void
     */
    public function testGameApprovalToDiscord()
    {
        Queue::fake();
        $this->post("administration/game/approve/{$this->game->id}");
        Queue::assertPushed(SendGameApprovalHookToDiscord::class);
    }

    /**
     * Confirm approving a game redirects back to the edit page
     *
     * @return void
     */
    public function testRedirectAfterApproval()
    {
        $response = $this->post("administration/game/approve/{$this->game->id}");
        $response->assertRedirect("administration/game/{$this->game->id}/edit");
    }

    /**
     * Confirm rejecting a game redirects back to the edit page
     *
     * @return void
     */
    public function testRedirectAfterRejection()
    {
        $response = $this->post("administration/game/reject/{$this->game->id}");
        $response->assertRedirect("administration/game/{$this->game->id}/edit");
    }

    /**
     * Deleting a game removes it completely
     *
     * @return void
     */
    public function testDeletionRemovesGame()
    {
        $this->delete("administration/game/{$this->game->id}");
        $this->assertDatabaseMissing('games', [
            'id' => $this->game->id,
        ]);
    }

    /**
     * Deleting a game redirects to general game administration page
     *
     * @return void
     */
    public function testDeletionRedirectsProperly()
    {
        $response = $this->delete("administration/game/{$this->game->id}");
        $response->assertRedirect('administration/game');
    }

    /**
     * Updating a game gives the game the correct values
     *
     * @return void
     */
    public function testUpdatingGivesCorrectData()
    {
        $this->putJson("administration/game/{$this->game->id}", [
            'name' => 'Best Game Ever',
            'description' => 'A game that is really fun to play.',
            'url' => 'http://bestgameintheworld.local/',
            'category_id' => Category::all()->random()->slug,
        ]);

        $this->game->refresh();

        $this->assertEquals($this->game->name, 'Best Game Ever');
        $this->assertEquals($this->game->url, 'http://bestgameintheworld.local/');
    }

    /**
     * Updating a game redirects back to the game management screen
     *
     * @return void
     */
    public function testUpdatingRedirectsProperly()
    {
        $response = $this->putJson("administration/game/{$this->game->id}", [
            'name' => 'Best Game Ever',
            'description' => 'A game that is really fun to play.',
            'url' => 'http://bestgameintheworld.local/',
            'category_id' => Category::all()->random()->slug,
        ]);

        $response->assertRedirect("administration/game/{$this->game->id}");
    }

    /**
     * Creates a new game
     *
     * @return void
     */
    public function testCreatingGame()
    {
        $oldCount = Game::count();
        $this->postJson("administration/game", [
            'name' => 'Best Game Ever',
            'description' => 'A game that is really fun to play.',
            'url' => 'http://bestgameintheworld.local/',
            'category_id' => Category::all()->random()->slug,
        ]);

        $newCount = Game::count();
        $this->assertTrue($oldCount < $newCount);
    }

    /**
     * Data Tables returns everything
     *
     * @return void
     */
    public function testDataTablesGivesAllData()
    {
        $response = $this->get("administration/game/datatables");
        $response->assertJsonCount(Game::count(), 'data');
    }
}
