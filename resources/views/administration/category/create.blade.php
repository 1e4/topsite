@extends('layouts.admin')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Category</h1>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add a new category</h6>
        </div>
        <div class="card-body">
            {!! \Form::open()->route('category.store') !!}
            {!! \Form::text('name', 'Name') !!}
            {!! \Form::submit('Create Category') !!}
            {!! \Form::close() !!}
        </div>
    </div>

@endsection