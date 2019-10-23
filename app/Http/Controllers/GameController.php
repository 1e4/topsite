<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use App\Http\Requests\CreateGameRequest;
use App\ImageUpload;
use App\Services\CategoryService;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GameController extends Controller
{
    /**
     * Returns a list of all a user's games
     *
     * @return View
     */
    public function index(): View
    {
        $games = Game::where('created_by', auth()->user()->id)
            ->get();

        return view('games.index', compact('games'));
    }

    /**
     * Shows the view to create a new game
     *
     * @param CategoryService $categoryService
     *
     * @return View
     */
    public function create(CategoryService $categoryService): View
    {
        $categories = $categoryService->buildSelectArray();

        return view('games.create', compact('categories'));
    }

    /**
     * Shows a listing based on slug
     *
     * @param String $slug
     *
     * @return RedirectResponse
     */
    public function show(String $slug): RedirectResponse
    {
        return redirect()
            ->route('front.listing.show', $slug);
    }

    /**
     * Stores a newly created game in the database
     *
     * @param CreateGameRequest $request
     *
     * @return RedirectResponse
     */
    public function store(CreateGameRequest $request, ImageService $imageService): RedirectResponse
    {
        $category = Category::findBySlug($request->input('category_id'));

        $game = new Game();
        $game->fill($request->all('name', 'url', 'description', 'category_id', 'callback_url'));
        $game->is_pending = true;
        $game->is_premium = false;
        $game->category_id = $category->id;
        $game->uuid = \Str::uuid();

        if ($request->has('banner_image')) {
            $banner = $request->file('banner_image');
            $imageName = $imageService->buildName($banner);
            $banner->move(public_path('images/uploads'), $imageName);

            $game->banner_image = $imageName;
        }

        $game->save();

        if ($request->has('images')) {
            ImageUpload::whereIn('filename', $request->input('images'))->each(function ($image) use ($game) {
                $image->game_id = $game->id;
                $image->save();
            });
        }

        flash('Game has been created, please wait while it is approved')->success();

        return redirect()
            ->route('front.game.index');
    }

    /**
     * Returns the view to edit an existing game
     *
     * @param Game $game
     * @param CategoryService $categoryService
     *
     * @return View
     */
    public function edit(Game $game, CategoryService $categoryService, ImageService $imageService): View
    {
        $categories = $categoryService->buildSelectArray();

        $imageCollection = ImageUpload::where('game_id', $game->id)->get();
        $images = $imageService->getBasics($imageCollection);

        return view('games.edit', compact('game', 'categories', 'images'));
    }

    /**
     * Updates an existing game in the database
     *
     * @param CreateGameRequest $request
     * @param Game $game
     *
     * @return RedirectResponse
     */
    public function update(CreateGameRequest $request, Game $game, ImageService $imageService): RedirectResponse
    {
        $category = Category::findBySlug($request->input('category_id'));

        $game->fill($request->all('name', 'url', 'description', 'category_id', 'callback_url'));
        $game->is_pending = true;
        $game->is_premium = false;
        $game->slug = null;
        $game->category_id = $category->id;

        if ($request->has('banner_image')) {
            if ($game->banner_image !== null) {
                // Remove old banner image
                $path = public_path() . '/images/uploads/' . $game->banner_image;

                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $banner = $request->file('banner_image');
            $imageName = $imageService->buildName($banner);
            $banner->move(public_path('images/uploads'), $imageName);

            $game->banner_image = $imageName;
        }

        $game->save();

        if ($request->has('images')) {
            ImageUpload::whereIn('filename', $request->input('images'))->each(function ($image) use ($game) {
                $image->game_id = $game->id;
                $image->save();
            });
        }

        flash('Game has been updated, it must now be re-approved')->success();

        return redirect()
            ->route('front.game.edit', $game);
    }

    /**
     * Removes a game from the database
     *
     * @param Game $game
     *
     * @return RedirectResponse
     */
    public function destroy(Game $game): RedirectResponse
    {
        $game->delete();

        flash('Game has been deleted')->success();

        return redirect()->route('front.game.index');
    }
}
