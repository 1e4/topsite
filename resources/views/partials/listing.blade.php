@php
    if(request()->has('page'))
        $key = $key  + ((request()->query('page') - 1) * 50)
@endphp

<div class="listing py-2 @if($listing->is_premium) listing-premium @endif mb-3">

    <div class="container">
        <div class="row">
            <div class="col-2 d-flex align-items-center flex-column align-self-center text-center">
                <div>#{{ $key + 1 }}</div>
                <div class="w-100"><a href="{{ route('front.listing.show', $listing->slug) }}" class="link-above-block-absolute">[details]</a></div>
            </div>
            <div class="col-8">

                @if($listing->banner_image && $listing->is_premium)
                    <div class="listing-banner">
                        <img src="{{ asset('images/uploads/' . $listing->banner_image) }}" style="max-height: 60px; max-width: 470px" />
                    </div>
                @endif
                <div class="listing-header">
                    <a href="{{ route('listing.out', $listing->slug) }}" target="_blank" ref="nofollow" class="link-above-block-absolute">
                        <h5 class="mb-0">{{ $listing->name }}</h5>
                    </a>
                </div>
                {{ $listing->description }}
            </div>
            <div class="col-1 text-success d-flex align-items-center">
                <div class="text-center w-100">
                    In
                    <div>{{ $listing->votes_in }}</div>
                </div>
            </div>
            <div class="col-1 text-info d-flex align-items-center">
                <div class="text-center w-100">
                    Out
                    <div>{{ $listing->votes_out }}</div>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('listing.out', $listing->slug) }}" class="link-block-absolute" target="_blank" ref="nofollow"></a>

</div>
