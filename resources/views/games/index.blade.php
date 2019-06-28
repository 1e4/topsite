@extends('layouts.app')

@section('content')
    @include('layouts.games-tabs')

    <div class="container p-0">
        <div class="row">
            @foreach($games as $game)

                <div class="col-xl-4 col-lg-6 col-sm-12">
                    <div class="card @if($game->is_pending) border-warning @else border-success @endif">
                        <div class="card-body">
                            <h3>{{ $game->name }}</h3>
                            <h5 class="text-muted">{{ $game->url }}</h5>
                        </div>

                        <a href="{{ route('front.game.show', $game->slug) }}" class="link-block-absolute"></a>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
@endsection