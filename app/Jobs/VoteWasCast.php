<?php

namespace App\Jobs;

use App\Game;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class VoteWasCast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $listing;

    /**
     * Create a new job instance.
     *
     * @param Game $listing
     */
    public function __construct(Game $listing)
    {
        $this->listing = $listing;

    }

    /**
     * Execute the job.
     *
     * @param Request $request
     * @return void
     */
    public function handle(Request $request)
    {
        $client = new Client([
            'timeout' => 3,
            'verify' => base_path('cacert.pem'),
            'base_uri' => $this->listing->callback_url
        ]);
        $query = $request->except(['_token', 'g-recaptcha-response']);
        $query = \Arr::prepend($query, $request->ip(), 'ip');
        try {
            $client->request('POST', '/', ['query' => $query]);
        } catch (GuzzleException $e) {
            Log::error('VoteWasCast error', [$e->getMessage()]);
        }
    }
}
