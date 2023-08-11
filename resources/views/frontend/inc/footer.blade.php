<section id="footer">
    <section class="bg-white border-top mt-auto">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-lg-3 col-md-6">
                    <a class="text-reset border-left text-center p-4 d-block" href="{{ route('terms') }}">
                        <i class="la la-file-text la-3x text-primary mb-2"></i>
                        <h4 class="h6">{{ translate('Terms & conditions') }}</h4>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a class="text-reset border-left text-center p-4 d-block" href="{{ route('returnpolicy') }}">
                        <i class="la la-mail-reply la-3x text-primary mb-2"></i>
                        <h4 class="h6">{{ translate('Return Policy') }}</h4>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a class="text-reset border-left text-center p-4 d-block" href="{{ route('supportpolicy') }}">
                        <i class="la la-support la-3x text-primary mb-2"></i>
                        <h4 class="h6">{{ translate('Support Policy') }}</h4>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a class="text-reset border-left border-right text-center p-4 d-block"
                        href="{{ route('privacypolicy') }}">
                        <i class="las la-exclamation-circle la-3x text-primary mb-2"></i>
                        <h4 class="h6">{{ translate('Privacy Policy') }}</h4>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-dark py-5 text-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-xl-4 text-center text-md-left">
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="d-block">
                            @if (get_setting('footer_logo') != null)
                                <img class="lazyload" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                    data-src="{{ uploaded_asset(get_setting('footer_logo')) }}"
                                    alt="{{ env('APP_NAME') }}" height="44">
                            @else
                                <img class="lazyload" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                    data-src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}"
                                    height="44">
                            @endif
                        </a>
                        <div class="my-3">
                            @php
                                echo get_setting('about_us_description');
                            @endphp
                        </div>
                        <div class="d-inline-block d-md-block">
                            <form class="form-inline" method="POST" action="{{ route('subscribers.store') }}">
                                @csrf
                                <div class="form-group mb-0">
                                    <input type="email" class="form-control"
                                        placeholder="{{ translate('Your Email Address') }}" name="email" required>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    {{ translate('Subscribe') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 ml-xl-auto col-md-4 mr-0">
                    <div class="text-center text-md-left mt-4">
                        <h4 class="fs-13 text-uppercase fw-600 border-bottom border-gray-900 pb-2 mb-4">
                            {{ translate('Contact Info') }}
                        </h4>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="d-block opacity-30">{{ translate('Address') }}:</span>
                                <span class="d-block opacity-70">{{ get_setting('contact_address') }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="d-block opacity-30">{{ translate('Phone') }}:</span>
                                <span class="d-block opacity-70">{{ get_setting('contact_phone') }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="d-block opacity-30">{{ translate('Email') }}:</span>
                                <span class="d-block opacity-70">
                                    <a href="mailto:{{ get_setting('contact_email') }}"
                                        class="text-reset">{{ get_setting('contact_email') }}</a>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="text-center text-md-left mt-4">
                        <h4 class="fs-13 text-uppercase fw-600 border-bottom border-gray-900 pb-2 mb-4">
                            {{ get_setting('widget_one') }}
                        </h4>
                        <ul class="list-unstyled">
                            @if (get_setting('widget_one_labels') != null)
                                @foreach (json_decode(get_setting('widget_one_labels'), true) as $key => $value)
                                    <li class="mb-2">
                                        <a href="{{ json_decode(get_setting('widget_one_links'), true)[$key] }}"
                                            class="opacity-50 hov-opacity-100 text-reset">
                                            {{ $value }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col-md-4 col-lg-2">
                    <div class="text-center text-md-left mt-4">
                        <h4 class="fs-13 text-uppercase fw-600 border-bottom border-gray-900 pb-2 mb-4">
                            {{ translate('My Account') }}
                        </h4>
                        <ul class="list-unstyled">
                            @if (Auth::check())
                                <li class="mb-2">
                                    <a class="opacity-50 hov-opacity-100 text-reset" href="{{ route('logout') }}">
                                        {{ translate('Logout') }}
                                    </a>
                                </li>
                            @else
                                <li class="mb-2">
                                    <a class="opacity-50 hov-opacity-100 text-reset" href="{{ route('user.login') }}">
                                        {{ translate('Login') }}
                                    </a>
                                </li>
                            @endif
                            <li class="mb-2">
                                <a class="opacity-50 hov-opacity-100 text-reset"
                                    href="{{ route('purchase_history.index') }}">
                                    {{ translate('Order History') }}
                                </a>
                            </li>
                            <li class="mb-2">
                                <a class="opacity-50 hov-opacity-100 text-reset" href="{{ route('wishlists.index') }}">
                                    {{ translate('My Wishlist') }}
                                </a>
                            </li>
                            <li class="mb-2">
                                <a class="opacity-50 hov-opacity-100 text-reset" href="{{ route('orders.track') }}">
                                    {{ translate('Track Order') }}
                                </a>
                            </li>
                            @if (
                                \App\Addon::where('unique_identifier', 'affiliate_system')->first() != null &&
                                    \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated)
                                <li class="mb-2">
                                    <a class="opacity-50 hov-opacity-100 text-light"
                                        href="{{ route('affiliate.apply') }}">{{ translate('Be an affiliate partner') }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    @if (get_setting('vendor_system_activation') == 1)
                        <div class="text-center text-md-left mt-4">
                            <h4 class="fs-13 text-uppercase fw-600 border-bottom border-gray-900 pb-2 mb-4">
                                {{ translate('Be a Seller') }}
                            </h4>
                            <a href="{{ route('shops.create') }}" class="btn btn-primary btn-sm shadow-md">
                                {{ translate('Apply Now') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="pt-3 pb-7 pb-xl-3 bg-black text-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="text-center text-md-left">
                        @php
                            echo get_setting('frontend_copyright_text');
                        @endphp
                    </div>
                </div>
                <div class="col-lg-4">
                    <ul class="list-inline my-3 my-md-0 social colored text-center">
                        @if (get_setting('facebook_link') != null)
                            <li class="list-inline-item">
                                <a href="{{ get_setting('facebook_link') }}" target="_blank" class="facebook"><i
                                        class="lab la-facebook-f"></i></a>
                            </li>
                        @endif
                        @if (get_setting('twitter_link') != null)
                            <li class="list-inline-item">
                                <a href="{{ get_setting('twitter_link') }}" target="_blank" class="twitter"><i
                                        class="lab la-twitter"></i></a>
                            </li>
                        @endif
                        @if (get_setting('instagram_link') != null)
                            <li class="list-inline-item">
                                <a href="{{ get_setting('instagram_link') }}" target="_blank" class="instagram"><i
                                        class="lab la-instagram"></i></a>
                            </li>
                        @endif
                        @if (get_setting('youtube_link') != null)
                            <li class="list-inline-item">
                                <a href="{{ get_setting('youtube_link') }}" target="_blank" class="youtube"><i
                                        class="lab la-youtube"></i></a>
                            </li>
                        @endif
                        @if (get_setting('linkedin_link') != null)
                            <li class="list-inline-item">
                                <a href="{{ get_setting('linkedin_link') }}" target="_blank" class="linkedin"><i
                                        class="lab la-linkedin-in"></i></a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="col-lg-4">
                    <div class="text-center text-md-right">
                        <ul class="list-inline mb-0">
                            @if (get_setting('payment_method_images') != null)
                                @foreach (explode(',', get_setting('payment_method_images')) as $key => $value)
                                    <li class="list-inline-item">
                                        <img src="{{ uploaded_asset($value) }}" height="30">
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <div class="aiz-mobile-bottom-nav d-xl-none fixed-bottom bg-white shadow-lg border-top">
        <div class="d-flex justify-content-around align-items-center">
            <a href="{{ route('home') }}"
                class="text-reset flex-grow-1 text-center py-3 border-right {{ areActiveRoutes(['home'], 'bg-soft-primary') }}">
                <i class="las la-home la-2x"></i>
            </a>
            <a href="{{ route('categories.all') }}"
                class="text-reset flex-grow-1 text-center py-3 border-right {{ areActiveRoutes(['categories.all'], 'bg-soft-primary') }}">
                <span class="d-inline-block position-relative px-2">
                    <i class="las la-list-ul la-2x"></i>
                </span>
            </a>
            <a href="{{ route('cart') }}"
                class="text-reset flex-grow-1 text-center py-3 border-right {{ areActiveRoutes(['cart'], 'bg-soft-primary') }}">
                <span class="d-inline-block position-relative px-2">
                    <i class="las la-shopping-cart la-2x"></i>
                    @if (Session::has('cart'))
                        <span class="badge badge-circle badge-primary position-absolute absolute-top-right"
                            id="cart_items_sidenav">{{ count(Session::get('cart')) }}</span>
                    @else
                        <span class="badge badge-circle badge-primary position-absolute absolute-top-right"
                            id="cart_items_sidenav">0</span>
                    @endif
                </span>
            </a>
            @if (Auth::check())
                @if (isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-reset flex-grow-1 text-center py-2">
                        <span class="avatar avatar-sm d-block mx-auto">
                            @if (Auth::user()->photo != null)
                                <img src="{{ custom_asset(Auth::user()->avatar_original) }}">
                            @else
                                <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                            @endif
                        </span>
                    </a>
                @else
                    <a href="javascript:void(0)" class="text-reset flex-grow-1 text-center py-2 mobile-side-nav-thumb"
                        data-toggle="class-toggle" data-target=".aiz-mobile-side-nav">
                        <span class="avatar avatar-sm d-block mx-auto">
                            @if (Auth::user()->photo != null)
                                <img src="{{ custom_asset(Auth::user()->avatar_original) }}">
                            @else
                                <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                            @endif
                        </span>
                    </a>
                @endif
            @else
                <a href="{{ route('user.login') }}" class="text-reset flex-grow-1 text-center py-2">
                    <span class="avatar avatar-sm d-block mx-auto">
                        <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                    </span>
                </a>
            @endif
        </div>
    </div>

</section>

<div class="popup-container" id="popup-container">
    <div class="background" id="background" onclick="hidePopup()">
    </div>
    <div class="popup-card">
        @php
            $header_logo = get_setting('header_logo');
        @endphp
        @if ($header_logo != null)
            <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}"
                class="mw-100 h-70px h-md-85px" height="70px">
        @else
            <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}"
                class="mw-100 h-70px h-md-85px" height="70px">
        @endif

        <h1 class="popup-header">
            عالم العدد
        </h1>

        <h5 class="popup-text hide-mob">
            هل أنت على استعداد لتلقي عروضنا الدورية والإستفاده من خدماتنا اللامحدودة
        </h5>

        <h3 class="popup-header hide-mob">
            شارك
        </h3>

        <div class="mb-3">
            <form class="form" method="POST" action="{{ route('subscribers.store') }}"
                style="text-align: right;">
                @csrf

                <div class="form-group mb-2 m-1">
                    <label for="supscriper_name" class="popup-text">
                        <h4>الأسم</h4>
                    </label>
                    <input type="text" id="supscriper_name" class="form-control" name="supscriper_name" required>
                </div>
                <div class="form-group mb-2 m-1">
                    <label for="supscriper_name" class="popup-text">
                        <h4>البريد الإلكتروني</h4>
                    </label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="form-group mb-2 m-1 hide-mob">
                    <ul class="popup-text" style="direction: rtl">
                        <li>
                            <h5>عروض حصرية</h5>
                        </li>
                        <li>
                            <h5>هدايا دوريه قيمه</h5>
                        </li>
                        <li>
                            <h5>ضمان وصيانه</h5>
                        </li>
                    </ul>
                </div>
                <div>
                    <button type="submit" class="btn popup-btn">
                        أشتراك
                    </button>
                </div>
            </form>
        </div>
        <h5 class="popup-text">www.toolsworldeg.com</h5>
    </div>
</div>


<style>
    .popup-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 2000;
    }

    .background {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .popup-card {
        background-color: #000000;
        padding: 20px;
        border-radius: 5px;
        max-width: 500px;
        text-align: center;
        z-index: 50;
        background-image: url({{ static_asset('assets/img/popUpBackground.png') }});
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
    }

    .popup-header {
        font-weight: bolder;
        color: #b50202;
        text-shadow: 1px 1px 0 #ffffff, -1px -1px 0 #ffffff, -1px 1px 0 #ffffff, 1px -1px 0 #ffffff;
    }

    .popup-text {
        font-weight: bold;
        color: #ffffff;
        text-shadow: 0 0 4px #000000, 0 0 2px #000000;
    }

    .popup-btn {
        background-color: white;
        font-weight: bold;
    }

    @media only screen and (max-width: 767px) {

        /* Styles for mobile devices */
        .hide-mob {
            display: none;
        }
    }
</style>

<script>
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function showPopup() {
        var popupContainer = document.getElementById("popup-container");
        if (!getCookie("popupShown")) {
            popupContainer.style.display = "flex";
            setCookie("popupShown", true, 7);
        }
    }

    function hidePopup() {
        var popupContainer = document.getElementById("popup-container");
        popupContainer.style.display = "none";
    }

    showPopup();
</script>
@if (Auth::check() && !isAdmin())
    <div class="aiz-mobile-side-nav collapse-sidebar-wrap sidebar-xl d-xl-none z-1035">
        <div class="overlay dark c-pointer overlay-fixed" data-toggle="class-toggle"
            data-target=".aiz-mobile-side-nav" data-same=".mobile-side-nav-thumb"></div>
        <div class="collapse-sidebar bg-white">
            @include('frontend.inc.user_side_nav')
        </div>
    </div>
@endif
