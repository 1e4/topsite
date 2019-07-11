@extends('layouts.app')

@section('content')
    @include('layouts.games-tabs')


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add a new game</h6>
        </div>
        <div class="card-body dropzone-form">
            {!! \Form::open()->route('front.game.store') !!}
            {!! \Form::text('name', 'Name') !!}
            {!! \Form::text('url', 'Url') !!}
            {!! \Form::textarea('description', 'Description') !!}
            {!! \Form::select('category_id', 'Category', $categories) !!}
            @include('partials.dropzone')
            {!! \Form::submit('Add Game') !!}
            {!! \Form::close() !!}
        </div>
    </div>
@endsection