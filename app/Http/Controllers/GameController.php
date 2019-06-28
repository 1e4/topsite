<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use App\Http\Requests\CreateGameRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller
{
    public function index(): View {

        $games = Game::where('created_by', auth()->user()->id)
            ->get();

        return view('games.index', compact('games'));
    }

    public function create(): View {
        $categories = [];
        $categories[] = "-- Select Category --";
        $categories = array_merge($categories, Category::all()->pluck('name')->toArray());

        return view('games.create', compact('categories'));
    }

    public function show($slug): RedirectResponse
    {
        return redirect()
            ->route('front.listing.show', $slug);
    }

    public function store(CreateGameRequest $request): RedirectResponse
    {
        $game = new Game();
        $game->fill($request->all('name', 'url', 'description', 'category_id'));
        $game->is_pending = true;
        $game->is_premium = false;
        $game->uuid = \Str::uuid();
        $game->save();

        flash('Game has been created, please wait while it is approved')->success();

        return redirect()
            ->route('front.game.index');
    }

    public function edit(Game $game): View {

        $categories = [];
        $categories[] = "-- Select Category --";
        $categories = array_merge($categories, Category::all()->pluck('name')->toArray());

        return view('games.edit', compact('game', 'categories'));
    }

    public function update(CreateGameRequest $request, Game $game): RedirectResponse
    {
        $game->fill($request->all('name', 'url', 'description', 'category_id'));
        $game->is_pending = true;
        $game->is_premium = false;
        $game->save();

        flash('Game has been updated')->success();

        return redirect()
            ->route('front.game.show', $game);
    }

    public function destroy(Game $game): RedirectResponse
    {
        $game->delete();

        flash('Game has been deleted')->success();

        return redirect()->route('front.game.index');
    }
}
