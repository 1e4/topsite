<?php

namespace App\Http\Controllers;

use App\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListingController extends Controller
{
    public function show($listing): View {
        $game = Game::findBySlug($listing);

        list($votesIn, $votesOut) = $this->buildCharts($game);

        return view('listing.show', compact('game', 'votesIn', 'votesOut'));
    }


    private function buildCharts(Game $game): array
    {

        $votesInLabels = $votesOutLabels = $this->getChartLabels();

        $votesInData = $this->getChartVotesInData($game);
        $votesOutData = $this->getChartVotesOutData($game);

        return [
            [
                'labels'    =>  $votesInLabels,
                'data'      =>  $votesInData
            ],
            [
                'labels'    =>  $votesOutLabels,
                'data'      =>  $votesOutData
            ]
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

    private function getChartVotesInData(Game $game): array {

        $dates = $this->getChartLabels();

        $carbon = Carbon::now()->startOfDay()->subDays(30);

        $data = [];

        foreach ($dates as $date) {

            $newDate = $carbon->clone()->addDay()->endOfDay();

            $count = $game->votesIn()->where('created_at', '>=', $carbon)
                ->where('created_at', '<', $newDate)
                ->count();

            $data[] = $count;

            $carbon = $newDate;
        }

        return $data;
    }

    private function getChartVotesOutData(Game $game): array {

        $dates = $this->getChartLabels();

        $carbon = Carbon::now()->startOfDay()->subDays(30);

        $data = [];

        foreach ($dates as $date) {

            $newDate = $carbon->clone()->addDay()->endOfDay();

            $count = $game->votesOut()->where('created_at', '>=', $carbon)
                ->where('created_at', '<', $newDate)
                ->count();

            $data[] = $count;

            $carbon = $newDate;
        }

        return $data;
    }
}
