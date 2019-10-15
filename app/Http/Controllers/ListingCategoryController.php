<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class ListingCategoryController extends Controller
{
    public function show($category)
    {
        $currentCategory = Category::whereSlug($category)->first();

        SEOTools::setTitle($currentCategory->name);

        $listings = Game::where('category_id', $currentCategory->id)
            ->approved()
            ->orderBy('votes_in', 'desc')
            ->paginate(50);

        return view('home', compact('currentCategory', 'listings'));
    }
}
