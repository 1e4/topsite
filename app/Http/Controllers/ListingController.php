<?php

namespace App\Http\Controllers;

use App\Game;
use App\Vote;
use Illuminate\View\View;
use App\Jobs\VoteWasCast;
use App\Http\Requests\VoteIn;
use App\Services\ChartService;
use Illuminate\Http\RedirectResponse;
use Artesaos\SEOTools\Facades\SEOTools;

class ListingController extends Controller
{
    /**
     * Shows the view for a specific listing
     *
     * @param String $listing
     *
     * @param ChartService $chartService
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

        if ($listing->callback_url) {
            VoteWasCast::dispatch($listing);
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
