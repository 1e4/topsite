<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use Illuminate\Http\Request;

class ListingCategoryController extends Controller
{
    public function show($category)
    {

        $currentCategory = Category::whereSlug($category)->first();

        $listings = Game::where('category_id', $currentCategory->id)
            ->where('is_pending', false)
            ->paginate(50);

        return view('home', compact('currentCategory', 'listings'));
    }
}
