<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\SendContactForm;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View {
        return view('contact.index');
    }

    public function store(SendContactForm $contactForm) {
        $form = new Contact();
        $form->email = auth()->user()->email ?? $contactForm->email;
        $form->subject = $contactForm->subject;
        $form->question = $contactForm->question;
        $form->user_id = auth()->user()->id ?? null;
        $form->save();

        flash('You query has been submitted, you will receive a reply by email')->success();

        return redirect()->route('front.contact');
    }
}
