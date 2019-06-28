<?php

namespace App\Http\Controllers\Administration;

use App\Category;
use App\Game;
use App\Http\Requests\CreateGameRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view("administration.game.index");
    }


    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatables(): JsonResponse
    {
        $games = Game::query();
        return DataTables::of($games)
            ->addColumn('action', function ($game) {
                $route = route('game.edit', $game);
                return '<a href="'. $route .'" class="btn btn-xs btn-primary"><i class="fas fa-pen fa-sm text-white-50"></i> Edit</a>';
            })->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $categories = [];
        $categories[] = "-- Select Category --";
        $categories = array_merge($categories, Category::all()->pluck('name')->toArray());

        return view('administration.game.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGameRequest $request): RedirectResponse
    {
        $game = new Game();
        $game->fill($request->all('name', 'url', 'description', 'category_id'));
        $game->is_pending = $request->has('is_pending') ? false : true;
        $game->is_premium = $request->has('is_premium');
        $game->uuid = \Str::uuid();
        $game->save();

        flash('Game has been created')->success();

        return redirect()
            ->route('game.show', [$game]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game): View
    {
        return view('administration.game.show', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game): View
    {
        $categories = [];
        $categories[] = "-- Select Category --";
        $categories = array_merge($categories, Category::all()->pluck('name')->toArray());

        return view('administration.game.edit', compact('game', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateGameRequest $request, Game $game): RedirectResponse
    {
        $game->fill($request->all('name', 'url', 'description', 'category_id'));
        $game->is_pending = $request->has('is_pending') ? false : true;
        $game->is_premium = $request->has('is_premium');
        $game->save();

        flash('Game has been updated')->success();

        return redirect()
            ->route('game.show', $game);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Game $game
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Game $game): RedirectResponse
    {
        $game->delete();

        flash('Game has been deleted')->success();

        return redirect()->route('game.index');
    }
}
