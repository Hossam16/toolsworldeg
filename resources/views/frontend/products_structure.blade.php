@foreach ($products as $key => $product)
    <div class="col mb-3">
        <div class="aiz-card-box h-100 border border-light rounded shadow-sm hov-shadow-md has-transition bg-white">
            <div class="position-relative">
                <a href="{{ route('product', $product->slug) }}" class="d-block">
                    <img class="img-fit lazyload mx-auto h-160px h-md-220px h-xl-270px h-xxl-250px"
                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                        alt="{{ $product->getTranslation('name') }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                </a>
                <div class="absolute-top-right aiz-p-hov-icon">
                    <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip"
                        data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                        <i class="la la-heart-o"></i>
                    </a>
                    <a href="javascript:void(0)" onclick="addToCompare({{ $product->id }})" data-toggle="tooltip"
                        data-title="{{ translate('Add to compare') }}" data-placement="left">
                        <i class="las la-sync"></i>
                    </a>
                    <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip"
                        data-title="{{ translate('Add to cart') }}" data-placement="left">
                        <i class="las la-shopping-cart"></i>
                    </a>
                </div>
            </div>
            <div class="p-md-3 p-2 text-left">
                <div class="fs-15">
                    @if (home_base_price($product->id) != home_discounted_base_price($product->id))
                        <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product->id) }}</del>
                    @endif
                    <span class="fw-700 text-primary">{{ home_discounted_base_price($product->id) }}</span>
                </div>
                <div class="rating rating-sm mt-1">
                    {{ renderStarRating($product->rating) }}
                </div>
                <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                    <a href="{{ route('product', $product->slug) }}"
                        class="d-block text-reset">{{ $product->getTranslation('name') }}</a>
                </h3>

                @if (
                    getAddons()->where('unique_identifier', 'club_point')->first() != null &&
                        getAddons()->where('unique_identifier', 'club_point')->first()->activated)
                    <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                        {{ translate('Club Point') }}:
                        <span class="fw-700 float-right">{{ $product->earn_point }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach
