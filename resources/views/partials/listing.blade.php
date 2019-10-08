@php
    if(request()->has('page'))
        $key = $key  + ((request()->query('page') - 1) * 50)
@endphp

<div class="listing py-2 @if($listing->is_premium) listing-premium @endif mb-3">
    <a href="{{ route('front.listing.show', $listing->slug) }}" class="link-block-absolute"></a>

    <div class="container">
        <div class="row">
            <div class="col-1 d-flex align-items-center">#{{ $key + 1 }}</div>
            <div class="col-7">

                @if($listing->banner_image)
                    <div class="listing-banner">
                        <img src="{{ asset('images/' . $listing->banner_image) }}" style="max-height: 60px; max-width: 470px" />
                    </div>
                @endif
                <div class="listing-header">
                    <a href="{{ $listing->url }}" class="link-above-block-absolute">
                        <h5 class="mb-0">{{ $listing->name }}</h5>
                    </a>
                </div>
                {{ $listing->description }}
            </div>
            <div class="col-2 text-success text-center d-flex align-items-center">
                <div>
                    In
                    <div>{{ $listing->votes_in }}</div>
                </div>
            </div>
            <div class="col-2 text-info text-center d-flex align-items-center">
                <div>
                    Out
                    <div>{{ $listing->votes_out }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
