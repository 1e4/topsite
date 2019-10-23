<?php

namespace App\Observers;

use App\Game;

class GameObserver
{
    public function creating(Game $game)
    {
        $game->created_by = auth()->user() ? auth()->id() : null;
    }
}
