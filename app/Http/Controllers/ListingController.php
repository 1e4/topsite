<?php

namespace App\Http\Controllers;

use App\Game;
use App\Http\Requests\VoteIn;
use App\Services\ChartService;
use App\Vote;
use Artesaos\SEOTools\Facades\SEOTools;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ListingController extends Controller
{
    /**
     * Shows the view for a specific listing
     *
     * @param String $listing
     *
     * @return View
     */
    public function show(String $listing, ChartService $chartService): View
    {
        $game = Game::findBySlug($listing);

        SEOTools::setTitle($game->name);
        SEOTools::setDescription($game->description);

        list($votesIn, $votesOut) = $chartService->buildCharts($game);

        return view('listing.show', compact('game', 'votesIn', 'votesOut'));
    }

    /**
     * Log a vote out
     *
     * @param String $slug
     *
     * @return View
     */
    public function out(String $slug): View
    {
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

    /**
     * Log a vote in
     *
     * @param String $slug
     *
     * @return View
     */
    public function in(String $slug): View
    {
        $listing = Game::findBySlug($slug);

        return view('listing.in', compact('listing'));
    }

    /**
     * Lets a user vote
     *
     * @param VoteIn $in
     * @param String $slug
     *
     * @return RedirectResponse
     */
    public function vote(VoteIn $in, String $slug): RedirectResponse
    {
        $listing = Game::findBySlug($slug);

        // @todo move this to a job because it takes a few seconds to work if it fails
        if ($listing->callback_url) {
            try {
                $client = new Client([
                    'timeout'   =>  3
                ]);
                $client->post($listing->callback_url, [
                    'query' =>  [
                        'ip'    =>  request()->ip(),
                        'username'  =>  request()->input('username', 'null')
                    ]
                ]);
            } catch (\Exception $exception) {
                //
            }
        }

        $vote = Vote::where('created_at', '>', now()->startOfDay())->firstOrNew([
            'listing_id'    =>  $listing->id,
            'voter_ip'      =>  request()->ip(),
            'vote_type'     =>  Vote::VOTE_IN
        ]);

        if ($vote->exists) {
            flash('You have already voted for this site today')->error();
        } else {
            $vote->save();

            flash("Your vote has been submitted for {$listing->name}")->success();
        }

        return redirect('/');
    }
}
