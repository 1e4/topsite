<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use Illuminate\View\View;
use Artesaos\SEOTools\Facades\SEOTools;

class ListingCategoryController extends Controller
{
    /**
     * Shows the view for a listing category
     *
     * @param String $category
     *
     * @return View
     */
    public function show(String $category): View
    {
        $currentCategory = Category::whereSlug($category)->firstOrFail();

        SEOTools::setTitle($currentCategory->name);

        $listings = Game::where('category_id', $currentCategory->id)
            ->approved()
            ->orderBy('votes_in', 'desc')
            ->paginate(50);

        return view('home', compact('currentCategory', 'listings'));
    }
}
