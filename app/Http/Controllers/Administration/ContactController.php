<?php

namespace App\Http\Controllers\Administration;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyToEnquiry;
use App\Mail\Enquiry;
use Carbon\Carbon;
use Carbon\Laravel\ServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('administration.contact.index');
    }

    public function show(Contact $contact)
    {
        return view('administration.contact.show', compact('contact'));
    }

    public function update(ReplyToEnquiry $enquiry, Contact $contact)
    {


        $contact->reply = $enquiry->reply;
        $contact->replied_by = auth()->user()->id;
        $contact->replied_at = new Carbon();
        $contact->save();

        try {
            Mail::to($contact->email)
                ->send(new Enquiry($contact));
        } catch (\Exception $exception) {

        }

        flash('Your reply has been sent')->success();

        return back();
    }

    public function datatables(): JsonResponse
    {
        $contact = Contact::query();

        if (request()->has('filter')) {
            if (request()->query('filter') === 'answered') {
                $contact->where('reply', '!=', null);
            }
        } else {
            $contact->where('reply', null);
        }

        return DataTables::of($contact)
            ->addColumn('action', function ($enquiry) {
                $route = route('contact.show', $enquiry);
                return '<a href="' . $route . '" class="btn btn-xs btn-primary"><i class="fas fa-pen fa-sm text-white-50"></i> View</a>';
            })->make(true);
    }

}
