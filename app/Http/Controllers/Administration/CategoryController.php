<?php

namespace App\Http\Controllers\Administration;

use App\Category;
use App\Game;
use App\Http\Requests\CreateCategoryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view("administration.category.index");
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatables(): JsonResponse
    {
        $categories = Category::query();
        return DataTables::of($categories)
            ->addColumn('action', function ($category) {
                $route = route('category.edit', $category);
                return '<a href="' . $route . '" class="btn btn-xs btn-primary"><i class="fas fa-pen fa-sm text-white-50"></i> Edit</a>';
            })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('administration.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CreateCategoryRequest $request): RedirectResponse
    {
        $category = new Category();
        return $this->update($request, $category);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show(Category $category): View
    {
        return view('administration.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(Category $category): View
    {
        return view('administration.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateCategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CreateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->fill($request->all('name'));
        $category->save();

        flash('Category has been updated')->success();

        return redirect()
            ->route('category.show', $category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Category $category): RedirectResponse
    {
        Game::whereCategoryId($category->id)
            ->update(['category_id' => null]);

        $category->delete();

        flash('Category has been deleted')->success();

        return redirect()->route('category.index');
    }
}
