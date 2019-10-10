<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests\VoteIn;
use App\Vote;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
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

    public function out($slug): View {
        $hide_sidebar = true;

        $listing = Game::findBySlug($slug);

        $vote = Vote::firstOrNew([
            'listing_id'    =>  $listing->id,
            'voter_ip'      =>  request()->ip(),
            'vote_type'     =>  Vote::VOTE_OUT
        ]);

        $vote->save();

        return view('listing.out', compact('listing', 'hide_sidebar'));
    }

    public function in($slug): View {
        $listing = Game::findBySlug($slug);

        return view('listing.in', compact('listing'));
    }

    public function vote(VoteIn $in, $slug): RedirectResponse {

        $listing = Game::findBySlug($slug);

        $vote = Vote::firstOrNew([
            'listing_id'    =>  $listing->id,
            'voter_ip'      =>  request()->ip(),
            'vote_type'     =>  Vote::VOTE_IN
        ]);

        $vote->save();

        flash("Your vote has been submitted for {$listing->name}")->success();

        return redirect('/');

    }
}
