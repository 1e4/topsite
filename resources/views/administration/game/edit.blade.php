@extends('layouts.admin')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Game</h1>
        <div class="d-flex flex-row">
            @if($game->is_pending)
                {!! \Form::open()->route('game.approve', [$game])->post() !!}
                <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mr-3"><i
                        class="fas fa-check-circle fa-sm text-white-50"></i> Approve this game
                </button>
                {!! \Form::close() !!}
            @else

                {!! \Form::open()->route('game.reject', [$game])->post() !!}
                <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm mr-3"><i
                        class="fas fa-times-circle fa-sm text-white-50"></i> Reject this game
                </button>
                {!! \Form::close() !!}
            @endif
            {!! \Form::open()->route('game.destroy', [$game])->delete() !!}
            <button type="submit" onclick="if(confirm('Are you sure you want to delete this') === false) return false"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-cross fa-sm text-white-50"></i> Delete this game
            </button>
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
            {!! \Form::text('callback_url', 'Callback Url For Voting') !!}
            {!! \Form::textarea('description', 'Description') !!}
            {!! \Form::select('category_id', 'Category', $categories, $game->category->id) !!}
            {!! \Form::checkbox('is_premium', 'Is Premium', 1) !!}
            {!! \Form::submit('Update Game') !!}
            {!! \Form::close() !!}
        </div>
    </div>

@endsection
