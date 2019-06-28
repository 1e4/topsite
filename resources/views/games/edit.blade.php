@extends('layouts.app')

@section('content')
    @include('layouts.games-tabs')



    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Editing Game {{ $game->name }}</h6>
        </div>
        <div class="card-body">
            {!! \Form::open()->route('front.game.update', [$game])->fill($game)->put() !!}
            {!! \Form::text('name', 'Name') !!}
            {!! \Form::text('url', 'Url') !!}
            {!! \Form::textarea('description', 'Description') !!}
            {!! \Form::select('category_id', 'Category', $categories, $game->category->id) !!}
            {!! \Form::submit('Update Game') !!}
            {!! \Form::close() !!}
        </div>
    </div>
@endsection