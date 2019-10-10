@extends('layouts.app')

@section('content')
    @include('layouts.account-tabs')
    <div class="card">
        <div class="card-header">
            Update your Password
        </div>
        <div class="card-body">
            {!! Form::open()->route('account.password.post')->post()->idPrefix('change_password') !!}
            {!! Form::text('new_password', 'New Password')->type('password') !!}
            {!! Form::text('new_password_confirmation', 'New Password Confirmation')->type('password') !!}
            {!! Form::text('current_password', 'Current Password')->type('password') !!}
            {!! Form::submit('Update Password') !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
