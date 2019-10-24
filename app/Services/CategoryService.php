<?php

namespace App\Services;

use App\Category;

class CategoryService
{
    /**
     * Builds out the select array for choosing a category
     *
     * @return array
     */
    public function buildSelectArray(): array
    {
        $categories = [];
        $categories["none__"] = "-- Select Category --";
        $categories = array_merge($categories, Category::all()->pluck('name', 'slug')->toArray());
        return $categories;
    }
}
