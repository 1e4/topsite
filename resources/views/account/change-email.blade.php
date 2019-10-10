@extends('layouts.app')

@section('content')
    @include('layouts.account-tabs')

    <div class="card mb-3">
        <div class="card-header">
            Update your email (Current {{ auth()->user()->email }})
        </div>
        <div class="card-body">
            {!! Form::open()->route('account.email.post')->post()->idPrefix('change_email') !!}
            {!! Form::text('email', 'New Email')->type('email') !!}
            <p>
                Upon updating your current email, your account will require validation before actions can be made
            </p>
            {!! Form::submit('Update Email') !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
