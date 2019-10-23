<?php

namespace App\Http\Controllers\Administration;

use App\Category;
use App\Game;
use App\Http\Requests\CreateGameRequest;
use App\Jobs\SendGameApprovalHookToDiscord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
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

        if (request()->has('filter')) {
            if (request()->query('filter') === 'pending-review') {
                $games->where('is_pending', 1);
            }
        }

        return DataTables::of($games)
            ->addColumn('action', function ($game) {
                $route = route('game.edit', $game);
                return '<a href="' . $route . '" class="btn btn-xs btn-primary"><i class="fas fa-pen fa-sm text-white-50"></i> Edit</a>';
            })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(CategoryService $categoryService): View
    {
        $categories = $categoryService->buildSelectArray();

        return view('administration.game.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateGameRequest $request
     * @return RedirectResponse
     */
    public function store(CreateGameRequest $request): RedirectResponse
    {
        $category = Category::findBySlug($request->input('category_id'));

        $game = new Game();
        $game->fill($request->all('name', 'url', 'description', 'callback_url'));
        $game->is_pending = $request->has('is_pending') ? false : true;
        $game->is_premium = $request->has('is_premium');
        $game->uuid = \Str::uuid();
        $game->category_id = $category->id;
        $game->save();

        flash('Game has been created')->success();

        return redirect()
            ->route('game.show', [$game]);
    }

    /**
     * Display the specified resource.
     *
     * @param Game $game
     * @return View
     */
    public function show(Game $game): View
    {
        return view('administration.game.show', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Game $game
     * @return View
     */
    public function edit(Game $game, CategoryService $categoryService): View
    {
        $categories = $categoryService->buildSelectArray();

        return view('administration.game.edit', compact('game', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateGameRequest $request
     * @param Game $game
     * @return RedirectResponse
     */
    public function update(CreateGameRequest $request, Game $game): RedirectResponse
    {
        $category = Category::findBySlug($request->input('category_id'));

        $game->fill($request->all('name', 'url', 'description', 'callback_url'));
        $game->is_premium = $request->has('is_premium');
        $game->category_id = $category->id;
        $game->slug = null;
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

    /**
     * Approves a pending game submission
     *
     * @param Game $game
     *
     * @return RedirectResponse
     */
    public function approveGame(Game $game): RedirectResponse
    {
        $game->is_pending = false;
        $game->save();

        SendGameApprovalHookToDiscord::dispatch($game);

        flash("Game has been approved");

        return redirect()->route('game.edit', $game);
    }

    /**
     * Rejects a pending game submission
     *
     * @param Game $game
     *
     * @return RedirectResponse
     */
    public function rejectGame(Game $game): RedirectResponse
    {
        $game->is_pending = true;
        $game->save();

        flash("Game has been rejected")->success();

        return redirect()->route('game.edit', $game);
    }
}
