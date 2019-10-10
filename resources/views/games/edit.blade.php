@extends('layouts.app')

@section('content')
    @include('layouts.games-tabs')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Vote Snippet For {{ $game->name }}</h6>
        </div>
        <div class="card-body">

            <p>
                Use the snippet below to add a vote link to your website
            </p>

            <div class="mb-4">
                <a href="{{ route('listing.in', [$game->slug]) }}" target="_blank" rel="nofollow">
                    <img src="{{ asset('images/theme/vote_for_button.jpg') }}" />
                </a>
            </div>

            <pre class="mb-0">
{!! htmlentities("<a href='". route('listing.in', [$game->slug])."' target='_blank' rel='nofollow'>
    <img src=". asset('images/theme/vote_for_button.jpg') ." />
</a>") !!}
            </pre>
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Editing Game {{ $game->name }}</h6>
        </div>
        <div class="card-body dropzone-form">
            {!! \Form::open()->route('front.game.update', [$game])->fill($game)->put()->multipart() !!}
            @include('games.form')
            {!! \Form::submit('Update Game') !!}
            {!! \Form::close() !!}
        </div>
    </div>
@endsection
