@extends('layouts.admin')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Game</h1>
        <div class="d-flex flex-row">
            {!! \Form::open()->route('game.destroy', [$game])->delete() !!}
            <button type="submit" onclick="if(confirm('Are you sure you want to delete this') === false) return false" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-cross fa-sm text-white-50"></i> Delete this game</button>
            {!! \Form::close() !!}
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Editing Game {{ $game->name }}</h6>
        </div>
        <div class="card-body">
            {!! \Form::open()->route('game.update', [$game])->fill($game)->put() !!}
            {!! \Form::text('name', 'Name') !!}
            {!! \Form::text('url', 'Url') !!}
            {!! \Form::textarea('description', 'Description') !!}
            {!! \Form::select('category_id', 'Category', $categories, $game->category->id) !!}
            {!! \Form::checkbox('is_pending', 'Is Visible', 1, $game->is_pending) !!}
            {!! \Form::checkbox('is_premium', 'Is Premium', 1, $game->is_premium) !!}
            {!! \Form::submit('Update Game') !!}
            {!! \Form::close() !!}
        </div>
    </div>

@endsection
