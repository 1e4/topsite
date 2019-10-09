@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <h2>Contact Us</h2>
            <p>You can use the below form to contact {{ config('app.name') }}</p>
            @guest
                <p>Since you are not logged in an email is required</p>
            @elseguest
                <p>Your email has been autofilled from your account as you are logged in</p>
            @endguest

            {!! Form::open('front.contact.store') !!}
            {!! Form::text('email', 'Your Email', auth()->user()->email ?? '') !!}
            {!! Form::text('subject', 'Subject') !!}
            {!! Form::textarea('question', 'Question')->attrs([
            'rows'  =>  10,
            ]) !!}

            {!! Form::submit('Send Enquiry') !!}

            {!! Form::close() !!}
        </div>
    </div>

@endsection
