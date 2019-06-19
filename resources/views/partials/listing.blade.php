@php
    if(request()->has('page'))
        $key = $key  + ((request()->query('page') - 1) * 50)
@endphp

<div class="listing py-2 @if($listing->is_premium) listing-premium @endif mb-3">
    <a href="{{ route('front.listing.show', $listing) }}" class="link-block-absolute"></a>

    <div class="container">
        <div class="row">
            <div class="col-1 d-flex align-items-center">#{{ $key + 1 }}</div>
            @if($listing->banner)
                <div class="col-12">
                    <div class="listing-banner"></div>
                </div>
            @endif
            <div class="col-7">
                <div class="listing-header">
                    <a href="{{ $listing->url }}" class="link-above-block-absolute">
                        <h3>{{ $listing->name }}</h3>
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