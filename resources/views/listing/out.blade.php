@extends('layouts.app')

@section('content')

    <div class="text-center">

        <h2 class="my-5">Redirecting</h2>
        <p>Redirecting you to {{ $listing->url }} in a <span id="countdown">5</span> seconds, click proceed to not wait</p>

        <a href="{{ $listing->url }}" class="btn btn-primary" target="_blank" ref="nofollow">Proceed &raquo;</a>

    </div>
@endsection

@push('scripts')


    <script>
        $(document).ready(function () {
            let count = 5;

            setInterval(function() {

                if(count === 0)
                {
                    window.location = '{{ $listing->url }}'
                    return;
                }

                count--;
                $("#countdown").html(count);
            }, 1000);
        })
    </script>
@endpush
