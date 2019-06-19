<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;

class ListingsHomeController extends Controller
{
    public function index()
    {
        $listings = Game::paginate(50);

        return view('home', compact('listings'));
    }
}
