@extends('layouts.admin')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Viewing Game</h1>
        <div class="d-flex flex-row">
            <a href="{{ route('game.edit', $game) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-4"><i class="fas fa-pen fa-sm text-white-50"></i> Edit this game</a>
            {!! \Form::open()->route('game.destroy', [$game])->delete() !!}
            <button type="submit" onclick="if(confirm('Are you sure you want to delete this') === false) return false" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-cross fa-sm text-white-50"></i> Delete this game</button>
            {!! \Form::close() !!}
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Viewing "{{ $game->name }}"</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>Name</td>
                    <td>{{ $game->name }}</td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>{{ $game->description }}</td>
                </tr>
                <tr>
                    <td>Url</td>
                    <td>{{ $game->url }}<a href="{{ $game->url }}" target="_blank" rel="nofollow">(open)</a></td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td><a href="{{ route('category.show', $game->category->id) }}">{{ $game->category->name }}</a></td>
                </tr>
                <tr>
                    <td>Slug</td>
                    <td>{{ $game->slug }}</td>
                </tr>
                <tr>
                    <td>Pending</td>
                    <td>{{ $game->is_pending === false ? 'Review Needed' : 'Active' }}</td>
                </tr>
                <tr>
                    <td>Premium</td>
                    <td>{{ $game->is_premium === true ? 'Premium' : 'Standard' }}</td>
                </tr>
                <tr>
                    <td>Votes In</td>
                    <td>{{ number_format($game->votes_in) }}</td>
                </tr>
                <tr>
                    <td>Votes Out</td>
                    <td>{{ number_format($game->votes_in) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
