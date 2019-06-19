<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListingsHomeController extends Controller
{
    public function index(): View
    {
        $listings = Game::where('is_pending', false)->paginate(50);

        return view('home', compact('listings'));
    }
}
