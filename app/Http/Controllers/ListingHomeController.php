<?php

namespace App\Http\Controllers;

use App\Game;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\View\View;

class ListingHomeController extends Controller
{
    /**
     * Shows the home view
     *
     * @return View
     */
    public function index(): View
    {
        $listings = Game::approved()
            ->orderBy('votes_in', 'desc')
            ->paginate(50);

        SEOTools::setTitle('Home');

        return view('home', compact('listings'));
    }
}
