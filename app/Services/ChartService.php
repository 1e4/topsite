<?php

namespace App\Services;

use App\Game;
use Carbon\Carbon;

class ChartService
{
    /**
     * Builds the charts for votes for a game
     *
     * @param Game $game
     *
     * @return array
     */
    public function buildCharts(Game $game): array
    {
        $voteLabels = $this->getChartLabels();

        $votesInData = $this->getVotesInData($game);
        $votesOutData = $this->getVotesOutData($game);

        return [
            [
                'labels'    =>  $voteLabels,
                'data'      =>  $votesInData
            ],
            [
                'labels'    =>  $voteLabels,
                'data'      =>  $votesOutData
            ]
        ];
    }

    /**
     * Gets the labels for the chart
     *
     * @return array
     */
    public function getChartLabels(): array
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
    public function getChartData(): array
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

    /**
     * Gets the chart data for votes in for a game
     *
     * @param Game $game
     *
     * @return array
     */
    public function getVotesInData(Game $game): array
    {
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

    /**
     * Gets the chart data for votes out for a game
     *
     * @param Game $game
     *
     * @return array
     */
    public function getVotesOutData(Game $game): array
    {
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
