<?php

namespace App\Jobs;

use App\Game;
use App\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendGameApprovalHookToDiscord implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $game;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $discordWebhookUrl = Settings::where('key', 'discord_webhook')->first()->value;

        if (!$discordWebhookUrl || !filter_var($discordWebhookUrl, FILTER_VALIDATE_URL)) {
            return;
        }

        $color = hexdec('#43cea2');

        $route = route('front.listing.show', $this->game->slug);

        try {
            $embedData = array(
                "author" => array(
                    "url" => $route,
                ),
                "title" => "A new game has been approved on pbbg.com",
                "url" => $route,
                "description" => "A new game {$this->game->name} has been published at {$route}",
                "color" => $color,
            );


            $discordClient = new \DiscordWebhooksPHP\Client($discordWebhookUrl);

            $discordClient->setUsername('Topsite Bot'); // Optional
            $discordClient->setEmbedData($embedData); //Optional
            $discordClient->send();
        } catch (\DiscordWebhooksPHP\DiscordException $e) {
            echo 'Error:' . $e->getMessage() . '--' . $e->getCode();
            exit;
        }
    }
}
