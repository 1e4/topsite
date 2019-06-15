@extends('layouts.admin')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
        <div class="d-flex flex-row">
            {!! \Form::open()->route('user.destroy', [$user])->delete() !!}
            <button type="submit" onclick="if(confirm('Are you sure you want to delete this') === false) return false"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-cross fa-sm text-white-50"></i> Delete this User
            </button>
            {!! \Form::close() !!}
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Editing User {{ $user->name }}</h6>
        </div>
        <div class="card-body">
            {!! \Form::open()->route('user.update', [$user])->fill($user)->put() !!}
            {!! \Form::text('name', 'Name') !!}
            {!! \Form::text('email', 'Email') !!}
            {!! \Form::text('password', 'Password (Leave blank to not update)') !!}
            {!! \Form::checkbox('is_admin', 'Administrator', 1) !!}
            {!! \Form::checkbox('is_verified', 'Is Verified', 1, $user->email_verified_at !== null) !!}
            {!! \Form::submit('Update User') !!}
            {!! \Form::close() !!}
        </div>
    </div>

@endsection