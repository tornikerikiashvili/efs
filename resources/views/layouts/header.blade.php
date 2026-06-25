<!DOCTYPE html>
<html lang="{{ html_lang_attribute() }}">
<!--<![endif]-->

<head>
    <meta name="google-site-verification" content="lGD-ST7F_330uxZYLCNZCnOaKnp48Kys3yG6B7nYpp4" />

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-V27KQJEQDL"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-V27KQJEQDL');
    </script>

    <script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "x19mo7th9m");
    </script>

    @php
        $seoModel = $seoEntity ?? $localeSwitchEntity ?? null;
        $pageSeo = page_seo($seoModel, $seo ?? []);
        $canonical = canonical_url($seoModel);
        $hreflangLinks = hreflang_alternates($seoModel);
    @endphp

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ e($pageSeo['title']) }}</title>

    <link rel="canonical" href="{{ e($canonical) }}">
    @foreach ($hreflangLinks as $alternate)
        <link rel="alternate" hreflang="{{ $alternate['hreflang'] }}" href="{{ e($alternate['href']) }}">
    @endforeach

    <meta name="title" content="{{ e($pageSeo['title']) }}">
    <meta name="description" content="{{ e($pageSeo['description']) }}">
    @if (is_noindex_page())
        <meta name="robots" content="noindex, follow">
    @endif

    <meta property="og:type" content="{{ e($pageSeo['og_type']) }}" />
    <meta property="og:url" content="{{ e($canonical) }}" />
    <meta property="og:title" content="{{ e($pageSeo['og_title']) }}" />
    <meta property="og:description" content="{{ e($pageSeo['og_description']) }}" />
    <meta property="og:image" content="{{ e($pageSeo['og_image']) }}" />

    @if ($schemaJson = schema_json_ld($seoModel, $pageSeo))
        <script type="application/ld+json">{!! $schemaJson !!}</script>
    @endif

    <script src="/js/jquery.min.js"></script>
    <script src="/js/custom-anim.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <script src="/js/script.js?1"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="stylesheet" href="/css/style.css?1">
    <link rel="stylesheet" href="/css/content-box.css">
    <link rel="stylesheet" href="/css/image-box.css">
    <link rel="stylesheet" href="/css/animations.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="/css/components.css">
    <link rel="stylesheet" href="/css/flexslider.css?2">
    <link rel="stylesheet" href="/css/magnific-popup.css">
    <link rel="stylesheet" href="/css/contact-form.css">
    <link rel="stylesheet" href="/css/rich-text.css">
    <link rel="stylesheet" href="/css/skin.css?5">

    <style>
        .gm-control-active>img {
            box-sizing: content-box;
            display: none;
            left: 50%;
            pointer-events: none;
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%)
        }

        .gm-control-active>img:nth-child(1) {
            display: block
        }

        .gm-control-active:focus>img:nth-child(1),
        .gm-control-active:hover>img:nth-child(1),
        .gm-control-active:active>img:nth-child(1),
        .gm-control-active:disabled>img:nth-child(1) {
            display: none
        }

        .gm-control-active:focus>img:nth-child(2),
        .gm-control-active:hover>img:nth-child(2) {
            display: block
        }

        .gm-control-active:active>img:nth-child(3) {
            display: block
        }

        .gm-control-active:disabled>img:nth-child(4) {
            display: block
        }
    </style>

    <style>
        .gm-ui-hover-effect {
            opacity: .6
        }

        .gm-ui-hover-effect:hover {
            opacity: 1
        }

        .gm-ui-hover-effect>span {
            background-color: #000
        }

        @media (forced-colors:active),
        (prefers-contrast:more) {
            .gm-ui-hover-effect>span {
                background-color: ButtonText
            }
        }
    </style>
    <style>
        .gm-style .gm-style-cc a,
        .gm-style .gm-style-cc button,
        .gm-style .gm-style-cc span,
        .gm-style .gm-style-mtc div {
            font-size: 10px;
            box-sizing: border-box
        }

        .gm-style .gm-style-cc a,
        .gm-style .gm-style-cc button,
        .gm-style .gm-style-cc span {
            outline-offset: 3px
        }
    </style>
    <style>
        @media print {

            .gm-style .gmnoprint,
            .gmnoprint {
                display: none
            }
        }

        @media screen {

            .gm-style .gmnoscreen,
            .gmnoscreen {
                display: none
            }
        }
    </style>
    <style>
        .dismissButton {
            background-color: #fff;
            border: 1px solid #dadce0;
            color: #1a73e8;
            border-radius: 4px;
            font-family: Roboto, sans-serif;
            font-size: 14px;
            height: 36px;
            cursor: pointer;
            padding: 0 24px
        }

        .dismissButton:hover {
            background-color: rgba(66, 133, 244, .04);
            border: 1px solid #d2e3fc
        }

        .dismissButton:focus {
            background-color: rgba(66, 133, 244, .12);
            border: 1px solid #d2e3fc;
            outline: 0
        }

        .dismissButton:focus:not(:focus-visible) {
            background-color: #fff;
            border: 1px solid #dadce0;
            outline: none
        }

        .dismissButton:focus-visible {
            background-color: rgba(66, 133, 244, .12);
            border: 1px solid #d2e3fc;
            outline: 0
        }

        .dismissButton:hover:focus {
            background-color: rgba(66, 133, 244, .16);
            border: 1px solid #d2e2fd
        }

        .dismissButton:hover:focus:not(:focus-visible) {
            background-color: rgba(66, 133, 244, .04);
            border: 1px solid #d2e3fc
        }

        .dismissButton:hover:focus-visible {
            background-color: rgba(66, 133, 244, .16);
            border: 1px solid #d2e2fd
        }

        .dismissButton:active {
            background-color: rgba(66, 133, 244, .16);
            border: 1px solid #d2e2fd;
            box-shadow: 0 1px 2px 0 rgba(60, 64, 67, .3), 0 1px 3px 1px rgba(60, 64, 67, .15)
        }

        .dismissButton:disabled {
            background-color: #fff;
            border: 1px solid #f1f3f4;
            color: #3c4043
        }
    </style>
    <style>
        .gm-style-moc {
            background-color: rgba(0, 0, 0, .45);
            pointer-events: none;
            text-align: center;
            transition: opacity ease-in-out
        }

        .gm-style-mot {
            color: white;
            font-family: Roboto, Arial, sans-serif;
            font-size: 22px;
            margin: 0;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
            -ms-transform: translateY(-50%)
        }
    </style>
    <style>
        .gm-style img {
            max-width: none;
        }

        .gm-style {
            font: 400 11px Roboto, Arial, sans-serif;
            text-decoration: none;
        }
    </style>
</head>

<body class="device-l">
    <div class="parallax-mirror"
        style="visibility: hidden; z-index: -100; position: fixed; top: 799.016px; left: 0px; overflow: hidden; transform: translate3d(0px, 0px, 0px); height: 570.125px; width: 1440px;">
        <img class="parallax-slider" src="/images/hd-4.jpg"
            style="transform: translate3d(0px, 0px, 0px); position: absolute; left: 0px; height: 810px; width: 1440px; max-width: none; top: -659.213px;">
    </div>
    <div class="parallax-mirror"
        style="visibility: hidden; z-index: -100; position: fixed; top: 814.406px; left: 0px; overflow: hidden; transform: translate3d(0px, 0px, 0px); height: 593px; width: 1440px;">
        <img class="parallax-slider" src="/images/bg-6.jpeg"
            style="transform: translate3d(0px, 0px, 0px); position: absolute; left: 0px; height: 487px; width: 1440px; max-width: none; top: -651.525px;">
    </div>
    <div id="preloader" style="display: none;"></div>
    <header class="fixed-top scroll-change" data-menu-anima="fade-in" style="height: 104px;">
        <div class="navbar navbar-default mega-menu-fullwidth navbar-fixed-top" role="navigation">
            <div class="navbar-mini scroll-hide">
                <div class="container">
                    <div class="nav navbar-nav navbar-left">
                        <span><i class="fa fa-phone"></i><a href="tel:+995591516183">+995 591 51 61 83</a></span>
                        <hr>
                        <span><i class="fa fa-envelope"></i>info@ef-s.ge</span>
                        <hr>
                        <span> <i class="fa fa-map-marker"></i> {{ __('other.contact_address') }}</span>
                        <hr>
                        {{-- <span><i class="fa fa-calendar"></i>Mon - Sat: 8.00 - 19:00</span> --}}
                    </div>
                    <div class="nav navbar-nav navbar-right">
                        <div class="minisocial-group">
                            <a target="_blank" href="https://www.facebook.com/HSSEQmanagement"><i
                                    class="fa fa-facebook first"></i></a>
                            <a target="_blank" href="https://www.linkedin.com/company/81786613"><i
                                    class="fa fa-linkedin"></i></a>
                            {{-- <a target="_blank" href="#"><i class="fa fa-instagram"></i></a>
                            <a target="_blank" href="#"><i class="fa fa-youtube"></i></a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar navbar-main">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle">
                            <i class="fa fa-bars"></i>
                        </button>
                        <a class="navbar-brand mainlogo" href="{{ route('homepagefront') }}" style="">
                            <img class="logo-default" src="/images/Logo-{{ app()->getLocale() }}.png?2" alt="logo">
                            <img class="logo-retina" src="/images/Logo-{{ app()->getLocale() }}.png?2"
                                alt="logo">
                        </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="mega-tabs">
                                <a href="{{ route('about') }}">{{ __('menu.about.about_us') }}</a>
                            </li>
                            <li class="dropdown">
                                <a href="{{ route('services') }}" class="dropdown-toggle" data-toggle="dropdown"
                                    role="button">{{ __('menu.services') }} <span
                                        class="caret hideonmobile"></span></a>
                                <a href="#" class="dropdown-toggle customwith hideondesktop"
                                    data-toggle="dropdown" role="button"><span class="caret"></span></a>
                                <ul class="dropdown-menu multi-level fade-in"
                                    style="transition-duration: 300ms; animation-duration: 300ms; transition-timing-function: ease; transition-delay: 0ms;">
                                    @foreach ($services as $item)
                                        <li><a
                                                href="{{ route('services') }}#{{ $item['id'] }}">{{ $item['name_' . app()->getLocale()] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="mega-tabs">
                                <a class="" href="{{ route('projects') }}">{{ __('menu.projects') }}</a>
                            </li>
                            <li class="mega-tabs">
                                <a class="" href="{{ route('news') }}">{{ __('menu.news') }}</a>
                            </li>
                            <li class="mega-tabs">
                                <a class="" href="{{ route('blog') }}">{{ __('menu.blog') }}</a>
                            </li>
                            <li class="mega-tabs">
                                <a class="" href="{{ route('contact') }}">{{ __('menu.contact') }}</a>
                            </li>
                        </ul>
                        <div class="nav navbar-nav navbar-right">
                            <form action="{{ route('search') }}" method="GET" class="search-box-menu" role="search">
                                <div class="search-box scrolldown">
                                    <input type="text" name="q" class="form-control" placeholder="{{ __('other.search_placeholder') }}" value="{{ e(request('q', '')) }}" maxlength="200" autocomplete="off">
                                </div>
                                <button type="button" class="btn btn-default btn-search" aria-label="{{ __('other.search') }}">
                                    <span class="fa fa-search"></span>
                                </button>
                            </form>
                            <ul class="nav navbar-nav lan-menu">
                                <li class="dropdown">
                                    @if (App::getLocale() == 'ka')
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                            role="button"><img src="/images/ka-logo.png" alt="">GE<span
                                                class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ localized_switch_url('en', $localeSwitchEntity ?? null) }}"><img
                                                        src="/images/en.png" alt="">EN</a></li>
                                        </ul>
                                    @elseif(App::getLocale() == 'en')
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                            role="button"><img src="/images/en.png" alt="">EN<span
                                                class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ localized_switch_url('ka', $localeSwitchEntity ?? null) }}"><img
                                                        src="/images/ka-logo.png" alt="">KA</a></li>
                                        </ul>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <script>
        document.addEventListener('click', function(e) {
            var link = e.target.closest('.dropdown-menu a[href*="services#"]');
            if (!link) {
                return;
            }

            var url = new URL(link.href, window.location.origin);
            if (window.location.pathname.replace(/\/$/, '') !== url.pathname.replace(/\/$/, '')) {
                return;
            }

            e.preventDefault();
            window.location.href = url.pathname + '?_=' + Date.now() + url.hash;
        });

        $('.search-box-menu').on('submit', function (e) {
            var query = $(this).find('input[name="q"]').val().trim();
            if (!query) {
                e.preventDefault();
            }
        });

        $('.search-box-menu input[name="q"]').on('keydown', function (e) {
            if (e.key === 'Enter') {
                var query = $(this).val().trim();
                if (query) {
                    $(this).closest('form').trigger('submit');
                }
            }
        });
    </script>
