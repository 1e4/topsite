<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\SendContactForm;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    /**
     * Returns a list of all contact forms
     *
     * @return View
     */
    public function index(): View
    {
        return view('contact.index');
    }

    /**
     * Adds a new contact form
     *
     * @param SendContactForm $contactForm
     *
     * @return RedirectResponse
     */
    public function store(SendContactForm $contactForm): RedirectResponse
    {
        $form = new Contact();
        $form->email = auth()->user()->email ?? $contactForm->email;
        $form->subject = $contactForm->subject;
        $form->question = $contactForm->question;
        $form->user_id = auth()->id() ?? null;
        $form->save();

        flash('You query has been submitted, you will receive a reply by email')->success();

        return redirect()->route('front.contact');
    }
}
