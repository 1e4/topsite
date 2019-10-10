@extends('layouts.app')

@section('content')
    @each('partials.listing', $listings, 'listing')

    {!! $listings->links() !!}
@endsection
