@extends('layouts.app')

@section('content')

    <div class="text-center">

        <h2 class="my-5">Vote for {{ $listing->name }}</h2>
        <p class="text-left">{{ $listing->description }}</p>

        {!! Form::open()->route('listing.vote', [
            'listing'   =>  $listing->slug
        ]) !!}
        @if ($errors->has('g-recaptcha-response'))
            <div class="help-block mb-3">
                <strong>Recaptcha is required</strong>
            </div>
        @endif

        <div class="mb-4 d-flex justify-content-center">
            {!! NoCaptcha::display() !!}
        </div>

        @foreach(request()->query() as $k => $v)
            {!! Form::hidden($k, $v) !!}
        @endforeach

        {!! Form::submit('Vote for ' . $listing->name) !!}

        {!! Form::close() !!}


    </div>
@endsection

@push('scripts')
    {!! NoCaptcha::renderJs() !!}
@endpush
