<?php

namespace App\Http\Controllers\Administration;

use App\Game;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Returns the home view
     *
     * @return View
     */
    public function getHome(): View
    {
        $gamesReleasedChartLabels = $this->getChartLabels();
        $gamesReleasedChartData = $this->getChartData();

        $stats = [
            'gamesTotal' => Game::count(),
            'votesIn' => 0,
            'votesOut' => 0,
            'users' => User::all()->count(),
            'gamesPendingReview' => Game::where('is_pending', '=', true)->count(),
            'goldMembership' => Game::where('is_premium', '=', true)->count(),
        ];

        return view('administration.index', compact('gamesReleasedChartData', 'gamesReleasedChartLabels', 'stats'));
    }

    /**
     * Gets the labels for the chart
     *
     * @return array
     */
    private function getChartLabels(): array
    {
        $date = Carbon::now()->startOfDay()->subDays(30);
        $dates = [];

        for ($i = 1; $i < 31; $i++) {
            $date->addDay();
            $dates[] = $date->shortDayName . ' ' . $date->format("jS");
        }

        return $dates;
    }

    /**
     * Gets the data for the chart
     *
     * @return array
     */
    private function getChartData(): array
    {
        $dates = $this->getChartLabels();
        $carbon = Carbon::now()->startOfDay()->subDays(30);
        $data = [];

        foreach ($dates as $date) {
            $newDate = $carbon->clone()->addDay()->endOfDay();

            $data[] = Game::where('created_at', '>=', $carbon)
                ->where('created_at', '<', $newDate)
                ->count();

            $carbon = $newDate;
        }

        return $data;
    }
}
