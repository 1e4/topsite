<?php

namespace App\Http\Controllers\Administration;

use App\Game;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function getHome(): View
    {
        list($gamesReleasedChartData, $gamesReleasedChartLabels) = $this->buildGamesReleasedChart();

        $games = Game::all();

        $stats = [
            'gamesTotal' => $games->count(),
            'votesIn' => 0,
            'votesOut' => 0,
            'users' => User::all()->count(),
            'gamesPendingReview' => $games->where('is_pending', '=', true)->count(),
            'goldMembership' => $games->where('is_premium', '=', true)->count(),
        ];

        return view('administration.index', compact('gamesReleasedChartData', 'gamesReleasedChartLabels', 'stats'));
    }

    private function buildGamesReleasedChart(): array
    {

        $gamesReleasedChartLabels = $this->getChartLabels();

        $gamesReleasedChartData = $this->getChartData();

        return [
            $gamesReleasedChartData,
            $gamesReleasedChartLabels
        ];
    }

    private function getChartLabels(): array {

        $date = Carbon::now()->startOfDay()->subDays(30);

        $dates = [];

        for ($i = 1; $i < 31; $i++) {
            $date->addDay();
            $dates[] = $date->shortDayName . ' ' . $date->format("jS");
        }

        return $dates;
    }

    private function getChartData(): array {

        $dates = $this->getChartLabels();

        $carbon = Carbon::now()->startOfDay()->subDays(30);

        $data = [];

        $games = Game::where("created_at", ">=", $carbon)->get();

        foreach ($dates as $date) {

            $newDate = $carbon->clone()->addDay()->endOfDay();

            $data[] = $games->where('created_at', '>=', $carbon)
                ->where('created_at', '<', $newDate)
                ->count();

            $carbon = $newDate;
        }


        return $data;
    }

}
