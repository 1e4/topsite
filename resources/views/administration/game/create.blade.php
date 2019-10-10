@extends('layouts.admin')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add a new game</h1>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add a new game</h6>
        </div>
        <div class="card-body">
            {!! \Form::open()->route('game.store') !!}
            {!! \Form::text('name', 'Name') !!}
            {!! \Form::text('url', 'Url') !!}
            {!! \Form::text('callback_url', 'Callback Url For Voting') !!}
            {!! \Form::textarea('description', 'Description') !!}
            {!! \Form::select('category_id', 'Category', $categories) !!}
            {!! \Form::submit('Add Game') !!}
            {!! \Form::close() !!}
        </div>
    </div>

@endsection
