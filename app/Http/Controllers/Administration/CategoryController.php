<?php

namespace App\Http\Controllers\Administration;

use App\Category;
use App\Http\Requests\CreateCategoryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
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
                return '<a href="'. $route .'" class="btn btn-xs btn-primary"><i class="fas fa-pen fa-sm text-white-50"></i> Edit</a>';
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
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = new Category();
        $category->fill($request->all('name'));
        $category->save();

        flash('Category has been created')->success();

        return redirect()
            ->route('category.show', [$category]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category): View
    {
        return view('administration.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function update(CreateCategoryRequest $request, Category $category)
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
        $category->delete();

        flash('Category has been deleted')->success();

        return redirect()->route('category.index');
    }
}
