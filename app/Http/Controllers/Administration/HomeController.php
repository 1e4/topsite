<?php

namespace App\Http\Controllers\Administration;

use App\Game;
use App\Http\Controllers\Controller;
use App\Services\ChartService;
use App\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Returns the home view
     *
     * @return View
     */
    public function getHome(ChartService $chartService): View
    {
        $gamesReleasedChartLabels = $chartService->getChartLabels();
        $gamesReleasedChartData = $chartService->getChartData();

        $stats = [
            'gamesTotal' => Game::count(),
            'votesIn' => 0,
            'votesOut' => 0,
            'users' => User::count(),
            'gamesPendingReview' => Game::where('is_pending', '=', true)->count(),
            'goldMembership' => Game::where('is_premium', '=', true)->count(),
        ];

        return view('administration.index', compact('gamesReleasedChartData', 'gamesReleasedChartLabels', 'stats'));
    }
}
