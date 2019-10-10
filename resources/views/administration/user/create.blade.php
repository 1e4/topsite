@extends('layouts.admin')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create User</h1>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add a new user</h6>
        </div>
        <div class="card-body">
            {!! \Form::open()->route('user.store') !!}
            {!! \Form::text('name', 'Name') !!}
            {!! \Form::text('email', 'Name') !!}
            {!! \Form::text('password', 'Name') !!}
            {!! \Form::checkbox('is_admin', 'Administrator', 1) !!}
            {!! \Form::checkbox('is_verified', 'Is Verified', 1) !!}
            {!! \Form::submit('Create User') !!}
            {!! \Form::close() !!}
        </div>
    </div>

@endsection