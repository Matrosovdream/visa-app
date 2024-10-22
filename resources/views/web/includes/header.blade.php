<!-- header start -->
<header class="site-header header-style-one">
    <div class="header__top-wrap gray-bg">
        <div class="container">
            <div class="header__top ul_li_between">
                <div class="header__top-cta">
                    <img src="{{ asset('user/assets/img/icon/n_pad.svg') }}" alt="">
                    <span>Help Desk :</span> {{ $siteSettings['phone'] }}
                </div>
                <ul class="header__top-info ul_li">
                    <li><img src="{{ asset('user/assets/img/icon/time.svg') }}" alt="">
                    {{ $siteSettings['work_time'] }}
                </li>
                <li><img src="{{ asset('user/assets/img/icon/location.svg') }}" alt="">
                    {{ $siteSettings['address'] }}
                </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="header__wrap stricky">
        <div class="container">
            <div class="header__inner ul_li_between">
                <div class="header__logo">
                    <a href="/">
                        <img src="{{ asset('user/assets/img/logo/logo.svg') }}" alt="">
                    </a>
                </div>
                <div class="main-menu__wrap ul_li navbar navbar-expand-lg">
                    <nav class="main-menu collapse navbar-collapse">
                        <ul>

                            @foreach( $menuTop as $menu )
                                <li class="@if( isset($menu['childs']) ) menu-item-has-children @endif">
                                    <a href="{{ $menu['url'] }}"><span>{{ $menu['title'] }}</span></a>

                                    @if( isset($menu['childs']) )
                                        <ul class="submenu">
                                            @foreach( $menu['childs'] as $subMenu )
                                                <li class="menu-item">
                                                    <a href="{{ $subMenu->url }}"><span>{{ $subMenu->title }}</span></a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                </li>   
                            @endforeach

                            @if( Auth::check() )
                                <li class="menu-item menu-item-has-children">
                                    <a href="{{ route('dashboard.home') }}">
                                        <span>Dashboard</span>
                                    </a>
                                    <ul class="submenu">
                                        <li class="menu-item">
                                            <!-- Log out -->
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <span>Logout</span>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>   
                            @else
                                <li class="menu-item">
                                    <a href="{{ route('login') }}"><span>Login</span></a>
                                </li>   
                            @endif

                        </ul>
                    </nav>
                </div>
                <div class="xb-hamburger-menu">
                    <div class="xb-nav-mobile">
                        <div class="xb-nav-mobile-button"><i class="fal fa-bars"></i></div>
                    </div>
                </div>
                <ul class="header__action ul_li">
                    <li>
                        <a class="header__search header-search-btn" href="javascript:void(0);">
                            <img src="{{ asset('user/assets/img/icon/search.svg') }}" alt="">
                            Search
                        </a>
                    </li>
                    <li>
                        <div class="header__language">
                            <ul>
                                <li>
                                    <a href="#!" class="lang-btn">
                                        <div class="flag">
                                            <img src="{{ asset('user/assets/img/icon/us_flag.png') }}" alt="">
                                        </div>
                                        {{ $activeLanguage->name }}
                                        <div class="arrow_down"><img src="{{ asset('user/assets/img/icon/arrow_down.svg') }}" alt=""></div>
                                    </a>
                                    <ul class="lang_sub_list">
                                        @foreach( $languages as $language )
                                            <li>
                                                <a href="?setlang={{ $language->code }}">
                                                    {{ $language->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="header__language">
                            <ul>
                            <li>
                                    <a href="#!" class="lang-btn">
                                        <span>{{ $activeCurrency->symbol }}</span>
                                        {{ $activeCurrency->name }}
                                        <div class="arrow_down"><img src="{{ asset('user/assets/img/icon/arrow_down.svg') }}" alt=""></div>
                                    </a>
                                    <ul class="lang_sub_list">
                                        @foreach( $currencies as $currency )
                                            <li>
                                                <a href="?setcurrency={{ $currency->code }}">
                                                    <span>{{ $currency->symbol }}</span>
                                                    {{ $currency->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="xb-header-wrap">
        <div class="xb-header-menu">
            <div class="xb-header-menu-scroll">
                <div class="xb-menu-close xb-hide-xl xb-close"></div>
                <div class="xb-logo-mobile xb-hide-xl">
                    <a href="index.html" rel="home">
                        <img src="{{ asset('user/assets/img/logo/logo.svg') }}" alt="">
                    </a>
                </div>
                <div class="xb-header-mobile-search xb-hide-xl">
                    <form role="search" action="#">
                        <input type="text" placeholder="Search..." name="s" class="search-field">
                        <button type="submit" class="search-submit">
                        </button>
                    </form>
                </div>
                <nav class="xb-header-nav">
                    <ul class="xb-menu-primary clearfix">
                        <li class="menu-item menu-item-has-children">
                            <a href="#"><span>Home</span></a>
                            <ul class="sub-menu">
                                <li class="menu-item"><a href="index.html"><span>Immigration</span></a></li>
                                <li class="menu-item"><a href="home-studient-visa.html"><span>Studient
                                            Visa</span></a></li>
                                <li class="menu-item"><a href="home-travel-agency.html"><span>Travel
                                            Agency</span></a></li>
                                <li class="menu-item"><a href="home-rtl.html"><span>Demo RTL</span></a></li>
                            </ul>
                        </li>
                        <li class="menu-item menu-item-has-children">
                            <a href="#"><span>Pages</span></a>
                            <ul class="sub-menu">
                                <li class="menu-item"><a href="services.html"><span>Services</span></a></li>
                                <li class="menu-item"><a href="service-single.html"><span>Service
                                            Details</span></a></li>
                                <li class="menu-item"><a href="coaching.html"><span>Coaching</span></a></li>
                                <li class="menu-item"><a href="coaching-single.html"><span>Coaching
                                            Details</span></a></li>
                                <li class="menu-item"><a href="visa.html"><span>Visa</span></a></li>
                                <li class="menu-item"><a href="visa-single.html"><span>Visa Details</span></a>
                                </li>
                                <li class="menu-item"><a href="team.html"><span>Team</span></a></li>
                                <li class="menu-item"><a href="team-single.html"><span>Team Details</span></a>
                                </li>
                                <li class="menu-item"><a href="testimonial.html"><span>Testimonials</span></a>
                                </li>
                                <li class="menu-item"><a href="faq.html"><span>FAQ</span></a></li>
                            </ul>
                        </li>
                        <li class="menu-item"><a href="about.html"><span>About us</span></a></li>
                        <li class="menu-item menu-item-has-children">
                            <a href="#"><span>Country</span></a>
                            <ul class="sub-menu">
                                <li class="menu-item"><a href="country.html"><span>Country</span></a></li>
                                <li class="menu-item"><a href="country-single.html"><span>Country
                                            Details</span></a></li>
                            </ul>
                        </li>
                        <li class="menu-item menu-item-has-children">
                            <a href="#"><span>Blog</span></a>
                            <ul class="sub-menu">
                                <li class="menu-item"><a href="blog.html"><span>Blog</span></a></li>
                                <li class="menu-item"><a href="blog-single.html"><span>Blog Details</span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item"><a href="contact.html"><span>Contact</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="xb-header-menu-backdrop"></div>
    </div>
</header>
<!-- header end -->

<!-- header search start -->
<div class="header-search-form-wrapper">
    <div class="xb-search-close xb-close"></div>
    <div class="header-search-container">
        <form role="search" class="search-form" action="#">
            <input type="search" class="search-field" placeholder="Search …" value="" name="s">
        </form>
    </div>
</div>