<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Shows the listing of all accounts
     *
     * @return View
     */
    public function index(): View
    {
        return view('account.index');
    }

    /**
     * Gets the password change view
     *
     * @return View
     */
    public function getPassword(): View
    {
        return view('account.change-password');
    }

    /**
     * Gets the email change view
     *
     * @return View
     */
    public function getEmail(): View
    {
        return view('account.change-email');
    }

    /**
     * Updates a user's password
     *
     * @param UpdatePasswordRequest $passwordRequest
     *
     * @return RedirectResponse
     */
    public function updatePassword(UpdatePasswordRequest $passwordRequest): RedirectResponse
    {
        $user = auth()->user();
        $user->password = bcrypt($passwordRequest->new_password);
        $user->save();

        flash('Your password was updated')->success();

        return back();
    }

    /**
     * Updates a user's email
     *
     * @param UpdateEmailRequest $emailRequest
     *
     * @return RedirectResponse
     */
    public function updateEmail(UpdateEmailRequest $emailRequest): RedirectResponse
    {
        $user = auth()->user();
        $user->email = $emailRequest->email;
        $user->email_verified_at = null;
        $user->save();

        flash('Your email was updated')->success();

        return back();
    }
}
