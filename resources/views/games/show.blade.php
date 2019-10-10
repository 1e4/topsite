@extends('layouts.app')

@section('content')

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
                    <td>{{ number_format($game->votes_out) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
