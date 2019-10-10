<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListingHomeController extends Controller
{
    public function index(): View
    {
        $listings = Game::where('is_pending', false)
            ->orderBy('votes_in', 'desc')
            ->paginate(50);

        return view('home', compact('listings'));
    }
}
