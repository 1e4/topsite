<?php

namespace App\Http\Controllers\Administration;

use App\Games;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function getHome(): View
    {
        list($gamesReleasedChartData, $gamesReleasedChartLabels) = $this->buildGamesReleasedChart();

        $games = Games::all();

        $stats = [
            'gamesTotal' => $games->count(),
            'votesIn' => 0,
            'votesOut' => 0,
            'users' => User::all()->count(),
            'gamesPendingReview' => $games->where('pending', '=', true)->count(),
            'goldMembership' => $games->where('premium','=', true)->count(),
        ];

        return view('administration.index', compact('gamesReleasedChartData', 'gamesReleasedChartLabels', 'stats'));
    }

    private function buildGamesReleasedChart(): array
    {

        $gamesReleasedChartLabels = function () {
            $date = Carbon::now()->subDays(30);

            $dates = [];

            for ($i = 1; $i < 31; $i++) {
                $date->addDay();
                $dates[] = $date->shortDayName . ' ' . $date->format("jS");
            }

            return $dates;
        };

        $gamesReleasedChartData = function () use ($gamesReleasedChartLabels) {
            $dates = $gamesReleasedChartLabels();

            $carbon = Carbon::now()->subDays(30);

            $data = [];

            $games = Games::where("created_at", ">=", $carbon)->get();

            foreach ($dates as $date) {
                $newDate = $carbon->addDay();

                $data[] = $games->where('created_at', '>=', $date)
                    ->where('created_at', '<', $newDate)
                    ->count();

                $carbon = $newDate;
            }

            return $data;
        };

        return [
            $gamesReleasedChartData,
            $gamesReleasedChartLabels
        ];
    }

}