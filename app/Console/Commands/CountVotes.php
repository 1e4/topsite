<?php

namespace App\Console\Commands;

use App\Game;
use App\Vote;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CountVotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'count:votes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count the votes in and out for sites';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->output->note('Counting votes {name} {votes_in}/{votes_out}');

        $total_listings = 0;
        $total_in = 0;
        $total_out = 0;

        Game::chunk(50, function ($games) use (&$total_listings, &$total_in, &$total_out) {

            $games->each(function ($game) use (&$total_listings, &$total_in, &$total_out) {

                $total_votes_in = Vote::whereListingId($game->id)
                    ->whereVoteType(Vote::VOTE_IN)
                    ->count();


                $total_votes_out = Vote::whereListingId($game->id)
                    ->whereVoteType(Vote::VOTE_OUT)
                    ->count();

                $game->votes_in = $total_votes_in;
                $game->votes_out = $total_votes_out;

                $game->save();

                $total_in += $total_votes_in;
                $total_out += $total_votes_out;
                $total_listings++;

                $this->output->success("Counted votes for {$game->name} ({$total_votes_in}/{$total_votes_out})");
            });

        });

        $total_out = number_format($total_out);
        $total_in = number_format($total_in);
        $total_listings = number_format($total_listings);

        $this->output->note("Total Games {$total_listings}, total in votes {$total_in}, total out votes {$total_out}");
    }
}
