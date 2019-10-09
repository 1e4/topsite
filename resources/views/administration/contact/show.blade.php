@extends('layouts.admin')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Viewing Enquiry #{{ $contact->id }}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add a new game</h6>
        </div>
        <div class="card-body">
            <h3>
                <b>Question: {{ $contact->subject }}</b>
            </h3>
            <p>
                {{ $contact->question }}
            </p>
        </div>
    </div>

    @if($contact->reply)
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">A Reply has been given by {{ $contact->repliedBy->name }}</h6>
                <div class="card-body">
                    {{ $contact->reply }}
                </div>
            </div>
        </div>
    @else
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Your Reply</h6>
            </div>
            <div class="card-body">
                <p>This reply will be sent as an email to {{ $contact->email }}</p>
                {!! Form::open()->route('contact.update', [
                    'contact'   =>  $contact
                ])->put() !!}

                {!! Form::textarea('reply', 'Your Answer') !!}
                {!! Form::submit('Send Reply') !!}

                {!! Form::close() !!}
            </div>
        </div>
    @endif



@endsection
