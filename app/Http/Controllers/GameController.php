<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use App\Http\Requests\CreateGameRequest;
use App\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller
{
    public function index(): View
    {

        $games = Game::where('created_by', auth()->user()->id)
            ->get();

        return view('games.index', compact('games'));
    }

    public function create(): View
    {
        $categories = [];
        $categories["none__"] = "-- Select Category --";
        $categories = array_merge($categories, Category::all()->pluck('name', 'slug')->toArray());

        return view('games.create', compact('categories'));
    }

    public function show($slug): RedirectResponse
    {
        return redirect()
            ->route('front.listing.show', $slug);
    }

    public function store(CreateGameRequest $request): RedirectResponse
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
            $imageName = md5($banner->getClientOriginalName() . time()) . '.' . $banner->getClientOriginalExtension();
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

    public function edit(Game $game): View
    {

        $categories = [];
        $categories["none__"] = "-- Select Category --";
        $categories = array_merge($categories, Category::all()->pluck('name', 'slug')->toArray());

        $images = ImageUpload::where('game_id', $game->id)->get();

        $imageCache = [];

        foreach ($images as $image) {
            $img['name'] = $image->filename; //get the filename in array
            $img['size'] = filesize(public_path('images/uploads/' . $image->filename)); //get the flesize in array
            $imageCache[] = $img; // copy it to another array
        }

        $images = $imageCache;

        return view('games.edit', compact('game', 'categories', 'images'));
    }

    public function update(CreateGameRequest $request, Game $game): RedirectResponse
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
            $imageName = md5($banner->getClientOriginalName() . time()) . '.' . $banner->getClientOriginalExtension();
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

        flash('Game has been updated, it must now be re approved')->success();

        return redirect()
            ->route('front.game.edit', $game);
    }

    public function destroy(Game $game): RedirectResponse
    {
        $game->delete();

        flash('Game has been deleted')->success();

        return redirect()->route('front.game.index');
    }
}
