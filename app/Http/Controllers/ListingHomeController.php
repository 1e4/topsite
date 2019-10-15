<?php

namespace App\Http\Controllers;

use App\Game;
use App\Settings;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListingHomeController extends Controller
{
    public function index(): View
    {
        $listings = Game::approved()
            ->orderBy('votes_in', 'desc')
            ->paginate(50);

        SEOTools::setTitle('Home');

        return view('home', compact('listings'));
    }
}
