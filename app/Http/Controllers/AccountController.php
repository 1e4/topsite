<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View {
        return view('account.index');
    }

    public function getPassword(): View {
        return view('account.change-password');
    }

    public function getEmail(): View {
        return view('account.change-email');
    }

    public function updatePassword(UpdatePasswordRequest $passwordRequest): RedirectResponse {

        $user = User::find(auth()->user()->id);
        $user->password = bcrypt($passwordRequest->new_password);
        $user->save();

        flash('Your password was updated')->success();

        return back();
    }

    public function updateEmail(UpdateEmailRequest $emailRequest) {

        $user = User::find(auth()->user()->id);
        $user->email = $emailRequest->email;
        $user->email_verified_at = null;
        $user->save();

        flash('Your email was updated')->success();

        return back();
    }
}
