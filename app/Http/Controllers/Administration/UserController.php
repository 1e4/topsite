<?php

namespace App\Http\Controllers\Administration;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view("administration.user.index");
    }


    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function datatables(): JsonResponse
    {
        $games = User::query();
        return DataTables::of($games)
            ->addColumn('action', function ($game) {
                $route = route('user.edit', $game);
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
        return view('administration.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserRequest  $request
     * @return RedirectResponse
     */
    public function store(CreateUserRequest $request): RedirectResponse
    {
        $user = new User();
        $user->fill($request->all('name', 'email'));

        if ($request->has('is_verified')) {
            $user->email_verified_at = Carbon::now();
        }

        $user->is_admin = $request->has('is_admin');

        $user->password = bcrypt('password');
        $user->save();

        flash('User has been created')->success();

        return redirect()
            ->route('user.show', [$user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('administration.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('administration.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EditUserRequest  $request
     * @param  User  $user
     * @return RedirectResponse
     */
    public function update(EditUserRequest $request, User $user): RedirectResponse
    {
        $user->fill($request->all('name', 'email'));

        if ($request->has('is_verified')) {
            $user->email_verified_at = Carbon::now();
        }

        $user->is_admin = $request->has('is_admin');

        if ($request->has('password')) {
            $user->password = bcrypt('password');
        }

        $user->save();

        flash('User has been updated')->success();

        return redirect()
            ->route('user.show', [$user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        flash('User has been deleted')->success();

        return redirect()->route('user.index');
    }
}
