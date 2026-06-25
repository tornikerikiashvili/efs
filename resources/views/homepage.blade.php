@include('layouts.header', [
    'services' => ($cat = App\Models\Services::select('id', 'name_' . app()->getLocale())->where('status', 1)->get()),
])
<div class="section-empty no-paddings">
    <div class="section-slider">
        <div class="flexslider advanced-slider slider" data-options="animation:slide">
            <ul class="slides">
                @foreach ($mainsliders as $slider)
                    <li data-time="1000" class="">
                        <picture>
                            <source srcset="{{ $slider->getFirstMediaUrl('mainslider_' . app()->getLocale()) }}"
                                media="(min-width: 800px)">
                            <img src="{{ $slider->getFirstMediaUrl('mainmobileslider_' . app()->getLocale()) }}"
                                class="custom-slider-img">
                        </picture>
                        {{-- <img src="{{$slider->getFirstMediaUrl('mainslider_'.app()->getLocale())}}" class="custom-slider-img"> --}}
                    </li>
                @endforeach
            </ul>
            <ul class="flex-direction-nav">
                <li class="flex-nav-prev"><a class="flex-prev" href="#"></a></li>
                <li class="flex-nav-next"><a class="flex-next" href="#"></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="section-empty">
    <div class="container content">
        <div class="flexslider carousel outer-navs no-navs"
            data-options="minWidth:150,itemMargin:30,numItems:4,controlNav:false">
            <div class="flex-viewport" style="overflow: hidden; position: relative;">
                <ul class="slides homepage-icons"
                    style="width: 1000%; transition-duration: 0.6s; transform: translate3d(0px, 0px, 0px);">
                    @foreach ($services as $item)
                        <li style=" display: block;">
                            <div class="advs-box advs-box-top-icon" data-anima="rotate-20" data-trigger="hover">
                                <i class="fa icon anima" aid="0.5656996326410737">
                                    <img src="{{ $item->getFirstMediaUrl('icon') ?: ($item->icon ? '/images/homepage-icons/' . $item->icon : '') }}" alt="{{ e($item->imageAltForLocale()) }}">
                                </i>
                                <h3>{{ $item['name_' . app()->getLocale()] }}</h3>
                                {{-- <p>
                                Interdum iusto pulvinar consequuntur augue optioepellat fugus expedita fusce.
                            </p> --}}
                            </div>
                        </li>
                    @endforeach
                    {{-- <li style=" display: block;">
                        <div class="advs-box advs-box-top-icon" data-anima="rotate-20"
                            data-trigger="hover">
                            <i class="fa icon anima" aid="0.5656996326410737"
                                style="transition-duration: 500ms; animation-duration: 500ms; transition-timing-function: ease; transition-delay: 0ms;">
                            <img src="/images/homepage-icons/usafrtxoeba-da-zedamxedveloba.png">
                            </i>
                            <h3>შრომის უსაფრთხოება</h3>
                            <p>
                                Interdum iusto pulvinar consequuntur augue optioepellat fugus expedita fusce.
                            </p>
                        </div>
                    </li>
                    <li style="float: left; display: block;">
                        <div class="advs-box advs-box-top-icon" data-anima="rotate-20"
                            data-trigger="hover">
                            <i class="fa icon anima" aid="0.5656996326410737"
                                style="transition-duration: 500ms; animation-duration: 500ms; transition-timing-function: ease; transition-delay: 0ms;">
                            <img src="/images/homepage-icons/garemos-dacva.png">
                            </i>
                            <h3>გარემოს დაცვა</h3>
                            <p>
                                Interdum iusto pulvinar consequuntur augue optioepellat fugus expedita fusce.
                            </p>
                        </div>
                    </li> --}}
                </ul>
            </div>
            <ul class="flex-direction-nav">
                <li class="flex-nav-prev"><a class="flex-prev" href="#"></a></li>
                <li class="flex-nav-next"><a class="flex-next" href="#"></a></li>
            </ul>
        </div>
        <hr class="space">
        <div class="row vefrtical-row">
            <div class="col-md-6 home-head-texts-left" style="opacity: 0">
                <div class="title-base  text-left">
                    <hr>
                    {{-- <h2>ტესტ</h2> --}}
                    <p>{{ __('homepage.first_text_head') }}</p>
                </div>
                <p class="text-color">
                    {{ __('homepage.first_text') }}
                </p>
                <p>
                    {{ __('homepage.first_text2') }}
                </p>
            </div>

            <div class="col-md-6 home-head-texts-right" style="opacity: 0">
                <div class="list-items">
                    <div class="list-item">
                        <div class="row">
                            <div class="col-md-9">
                                <h3> {{ __('homepage.mini_list.head1') }}</h3>
                                <p>{{ __('homepage.mini_list.text1') }}</p>
                            </div>
                            <div class="col-md-3">
                                {{-- <span>Free</span> --}}
                            </div>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="row">
                            <div class="col-md-9">
                                <h3>{{ __('homepage.mini_list.head2') }}</h3>
                                <p>{{ __('homepage.mini_list.text2') }}</p>
                            </div>
                            <div class="col-md-3">
                                {{-- <span>Eco</span> --}}
                            </div>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="row">
                            <div class="col-md-9">
                                <h3>{{ __('homepage.mini_list.head3') }}</h3>
                                <p>{{ __('homepage.mini_list.text3') }}</p>
                            </div>
                            <div class="col-md-3">
                                {{-- <span>Future</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="space s">
                {{-- <a href="#" class="btn btn-lg"><i class="fa fa-angle-right"></i>View services</a> --}}
            </div>
        </div>
    </div>
</div>
<div class="section-bg-image parallax-window" data-natural-height="650" data-natural-width="1920" data-parallax="scroll"
    data-image-src="/images/home-parallax.jpg?4">
    <div class="container content fadedown" style="opacity: 0">
        <div class="row">
            <div class="col-md-12  col-sm-12">
                <div class="row proporzional-row" data-anima="" data-time="700" data-timeline="asc"
                    data-timeline-time="200">
                    <div class="col-md-4 customdetails">
                        <h2 class="text-normal no-margins text-center">{{ __('about.about2.mission') }}</h2>
                        <div class=" boxed-border border-color-gr anima fade-top"
                            style="position: relative; transition-duration: 700ms; animation-duration: 700ms; transition-timing-function: ease; transition-delay: 0ms;"
                            aid="0.17091586043351126">

                            <p>{{ __('about.about2.mission_text') }}</p>
                            <hr class="space xs">
                            {{-- <a href="#" class="btn-text">Details</a> --}}
                        </div>
                    </div>
                    <div class="col-md-4 customdetails">
                        <h2 class="text-normal no-margins text-center">{{ __('about.about2.goal') }}</h2>
                        <div class=" boxed-border border-color-yl anima fade-top"
                            style="position: relative; transition-duration: 700ms; animation-duration: 700ms; transition-timing-function: ease; transition-delay: 0ms;"
                            aid="0.3335518970764084">

                            <p>{{ __('about.about2.goal_text') }}</p>
                            <hr class="space xs">
                            {{-- <a href="#" class="btn-text">Details</a> --}}
                        </div>
                    </div>
                    <div class="col-md-4 customdetails">
                        <h2 class="text-normal no-margins text-center">{{ __('about.about2.values') }}</h2>
                        <div class=" boxed-border border-color-bl anima fade-top"
                            style="position: relative; transition-duration: 700ms; animation-duration: 700ms; transition-timing-function: ease; transition-delay: 0ms;"
                            aid="0.3032810925531586">

                            <p>{{ __('about.about2.values_text') }}</p>
                            <hr class="space xs">
                            {{-- <a href="#" class="btn-text">Details</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="section-empty no-paddings-y">
    <div class="container content">
        <hr class="space">
        <div class="row">
            <div class="col-md-4 hidden-sm visible-xs">
                <img data-anima="" data-time="700" src="/images/mk-3.png" alt=""
                    style="position: relative; transition-duration: 700ms; animation-duration: 700ms; transition-timing-function: ease; transition-delay: 0ms;"
                    aid="0.16947975179111752" class="fade-bottom">
            </div>
            <div class="col-md-8 col-sm-12">
                <div class="title-base text-left">
                    <hr>
                    <h2>Finance consulting</h2>
                    <p>Proven experience</p>
                </div>
                <p>
                    Our Finance consulting team have proven experience of working with clients through the lifecycle of
                    Finance change projects. Lorem ipsum dolor sit amet consectetur adipiscing elitsed do eiusmod tempor
                    incididunt utlabore et dolore magna aliqua.
                    Utenim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit
                    in voluptate velit esse cillumo.
                </p>
                <hr class="space m">
                <table class="grid-table border-table text-left">
                    <tbody>
                        <tr>
                            <td>
                                <h5 class="text-color">30 minutes</h5>
                                <h3 class="no-margins">$50.00</h3>
                            </td>
                            <td>
                                <h5 class="text-color">1 hour</h5>
                                <h3 class="no-margins">$80.00</h3>
                            </td>
                            <td>
                                <h5 class="text-color">Half day</h5>
                                <h3 class="no-margins">$350.00</h3>
                            </td>
                            <td>
                                <h5 class="text-color">Full day</h5>
                                <h3 class="no-margins">$500.00</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr class="space visible-sm">
            </div>
        </div>
    </div>
</div> --}}

{{-- <div class="section-bg-color no-paddings-y">
    <div class="container content">
        <hr class="space">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="title-base text-left">
                    <hr>
                    <h2>Professional courses</h2>
                    <p>Proven experience</p>
                </div>
                <p>
                    Our Finance consulting team have proven experience of working with clients through the lifecycle of
                    Finance change projects. Lorem ipsum dolor sit amet consectetur adipiscing elitsed do eiusmod tempor
                    incididunt utlabore et dolore magna aliqua.
                    Utenim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit
                    in voluptate velit esse cillumo.
                </p>
                <hr class="space m">
                <table class="grid-table border-table text-left">
                    <tbody>
                        <tr>
                            <td>
                                <h5 class="text-color">General</h5>
                                <h3 class="no-margins">$500.00</h3>
                            </td>
                            <td>
                                <h5 class="text-color">Security</h5>
                                <h3 class="no-margins">$1500.00</h3>
                            </td>
                            <td>
                                <h5 class="text-color">Laws</h5>
                                <h3 class="no-margins">$3500.00</h3>
                            </td>
                            <td>
                                <h5 class="text-color">Ensurance</h5>
                                <h3 class="no-margins">$5000.00</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr class="space visible-sm">
            </div>
            <div class="col-md-4 text-right hidden-sm visible-xs">
                <img data-anima="" data-time="700" src="/images/mk-4.png" alt=""
                    style="position: relative; transition-duration: 700ms; animation-duration: 700ms; transition-timing-function: ease; transition-delay: 0ms;"
                    aid="0.2801062024480754" class="fade-bottom">
            </div>
        </div>
    </div>
</div> --}}

{{-- <div class="section-empty">
    <div class="container content">
        <div class="maso-list">
            <div class="navbar navbar-inner">
                <div class="navbar-toggle"><i class="fa fa-bars"></i><span>Menu</span><i
                        class="fa fa-angle-down"></i></div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav over ms-minimal inner maso-filters nav-center">
                        <li class="current-active active"><a data-filter="maso-item">All projects</a></li>
                        <li><a data-filter="cat1">Renovation</a></li>
                        <li><a data-filter="cat2">Outdoor</a></li>
                        <li><a data-filter="cat3">Architecture</a></li>
                        <li><a data-filter="cat4">Gardening</a></li>
                        <li><a data-filter="cat5" href="#">Interior design</a></li>
                        <li><a class="maso-order" data-sort="asc"><i class="fa fa-arrow-down"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="maso-box row" style="position: relative; height: 537.11px;">
                <div data-sort="0" class="maso-item col-md-3 cat1"
                    style="position: absolute; left: 0%; top: 0px; visibility: visible;">
                    <div class="img-box adv-img adv-img-down-text grayscale" style="opacity: 1;">
                        <a class="img-box img-scale-up lightbox i-center" href="#">
                            <div class="caption">
                                <i class="fa fa-plus"></i>
                            </div>
                            <img src="/images/image-4.jpg" alt="">
                        </a>
                        <div class="caption-bottom">
                            <h2><a href="#">Modern bathroom</a></h2>
                            <p>April 2018</p>
                        </div>
                    </div>
                </div>
                <div data-sort="0" class="maso-item col-md-3  cat2 cat3 cat5"
                    style="position: absolute; left: 24.9351%; top: 0px; visibility: visible;">
                    <div class="img-box adv-img adv-img-down-text grayscale" style="opacity: 1;">
                        <a class="img-box img-scale-up lightbox i-center" href="#">
                            <div class="caption">
                                <i class="fa fa-plus"></i>
                            </div>
                            <img src="/images/image-5.jpg" alt="">
                        </a>
                        <div class="caption-bottom">
                            <h2><a href="#">Tech building</a></h2>
                            <p>Janaury 2018</p>
                        </div>
                    </div>
                </div>
                <div data-sort="0" class="maso-item col-md-3 cat2 cat4 cat5"
                    style="position: absolute; left: 49.9567%; top: 0px; visibility: visible;">
                    <div class="img-box adv-img adv-img-down-text grayscale" style="opacity: 1;">
                        <a class="img-box img-scale-up lightbox i-center" href="#">
                            <div class="caption">
                                <i class="fa fa-plus"></i>
                            </div>
                            <img src="/images/image-6.jpg" alt="">
                        </a>
                        <div class="caption-bottom">
                            <h2><a href="#">Lighting rooms</a></h2>
                            <p>Janauray 2018</p>
                        </div>
                    </div>
                </div>
                <div data-sort="0" class="maso-item col-md-3  cat2 cat3 cat4 cat5"
                    style="position: absolute; left: 74.9784%; top: 0px; visibility: visible;">
                    <div class="img-box adv-img adv-img-down-text grayscale" style="opacity: 1;">
                        <a class="img-box img-scale-up lightbox i-center" href="#">
                            <div class="caption">
                                <i class="fa fa-plus"></i>
                            </div>
                            <img src="/images/image-11.jpg" alt="">
                        </a>
                        <div class="caption-bottom">
                            <h2><a href="#">Interior garden</a></h2>
                            <p>February 2018</p>
                        </div>
                    </div>
                </div>
                <div data-sort="0" class="maso-item col-md-3 cat2 cat3"
                    style="position: absolute; left: 0%; top: 268px; visibility: visible;">
                    <div class="img-box adv-img adv-img-down-text grayscale" style="opacity: 1;">
                        <a class="img-box img-scale-up lightbox i-center" href="#">
                            <div class="caption">
                                <i class="fa fa-plus"></i>
                            </div>
                            <img src="/images/image-8.jpg" alt="">
                        </a>
                        <div class="caption-bottom">
                            <h2><a href="#">Vertical garden</a></h2>
                            <p>June 2018</p>
                        </div>
                    </div>
                </div>
                <div data-sort="0" class="maso-item col-md-3 cat2 cat3 cat4 cat5"
                    style="position: absolute; left: 24.9351%; top: 268px; visibility: visible;">
                    <div class="img-box adv-img adv-img-down-text grayscale" style="opacity: 1;">
                        <a class="img-box img-scale-up lightbox i-center" href="#">
                            <div class="caption">
                                <i class="fa fa-plus"></i>
                            </div>
                            <img src="/images/image-9.jpg" alt="">
                        </a>
                        <div class="caption-bottom">
                            <h2><a href="#">Big tower</a></h2>
                            <p>July 2018</p>
                        </div>
                    </div>
                </div>
                <div data-sort="0" class="maso-item col-md-3  cat2 cat3 cat4 cat5"
                    style="position: absolute; left: 49.9567%; top: 268px; visibility: visible;">
                    <div class="img-box adv-img adv-img-down-text grayscale" style="opacity: 1;">
                        <a class="img-box img-scale-up lightbox i-center" href="#">
                            <div class="caption">
                                <i class="fa fa-plus"></i>
                            </div>
                            <img src="/images/image-12.jpg" alt="">
                        </a>
                        <div class="caption-bottom">
                            <h2><a href="#">Wood apartments</a></h2>
                            <p>July 2018</p>
                        </div>
                    </div>
                </div>
                <div data-sort="0" class="maso-item col-md-3 cat2 cat3 cat4 cat5"
                    style="position: absolute; left: 74.9784%; top: 268px; visibility: visible;">
                    <div class="img-box adv-img adv-img-down-text grayscale" style="opacity: 1;">
                        <a class="img-box img-scale-up lightbox i-center" href="#">
                            <div class="caption">
                                <i class="fa fa-plus"></i>
                            </div>
                            <img src="/images/image-7.jpg" alt="">
                        </a>
                        <div class="caption-bottom">
                            <h2><a href="#">Tiny homes</a></h2>
                            <p>August 2018</p>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div> --}}

{{-- <div class="section-bg-image parallax-window" data-natural-height="1080" data-natural-width="1920"
    data-parallax="scroll" data-image-src="/images/hd-4.jpg">
    <div class="container content">
        <div class="row proporzional-row">
            <div class="col-md-3 boxed-border white middle-content text-left">
                <p>Auctor orci proin consequat magna natoque mattis nostra eiusmod esse lunga laboriosam luctus pulvinar
                    tenetur fugito similique.</p>
            </div>
            <div class="col-md-3  col-sm-12">
                <a class="img-box lightbox" href="/images/image-1.jpg" data-lightbox-anima="fade-right">
                    <img src="/images/image-1.jpg" alt=""
                        style="max-width: 454px; width: 454px; margin-left: -95px;">
                </a>
            </div>
            <div class="col-md-3 boxed white middle-content">
                <p>Lorem ipsum dolor sit amet consectetur adipiscing elitsed do eiusmod tempor incididunt utlabore et
                    dolore magna aliqua.</p>
            </div>
            <div class="col-md-3 middle-content text-left">
                <h4>Services</h4>
                <h2 class="text-color">Awesome</h2>
                <p class="no-margins">Lorem ipsum dolor sit amet consectetur adipo.</p>
            </div>
        </div>
    </div>
</div> --}}

<div class="section-empty">
    <div class="container content fade2" style="opacity: 0">
        <div class="flexslider carousel outer-navs png-over text-center no-navs"
            data-options="numItems:6,controlNav:false,directionNav:true">
            <div class="flex-viewport">
                <ul class="slides">
                    @foreach ($partnerLogos as $partner)
                        <li>
                            @if ($partner->url)
                                <a class="img-box" target="_blank" rel="nofollow noopener" href="{{ $partner->url }}">
                                    <img src="{{ $partner->getFirstMediaUrl('main') }}" alt="{{ e($partner->imageAltForLocale()) }}" draggable="false">
                                </a>
                            @else
                                <span class="img-box">
                                    <img src="{{ $partner->getFirstMediaUrl('main') }}" alt="{{ e($partner->imageAltForLocale()) }}" draggable="false">
                                </span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
            <ul class="flex-direction-nav">
                <li class="flex-nav-prev"><a class="flex-prev" href="#"></a></li>
                <li class="flex-nav-next"><a class="flex-next" href="#"></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="container box-middle-container row-19 box-transparent map-contact-anim" style="opacity: 0">
    <div class="col-md-6">
        <div class="google-map" data-trigger="initialized"
            style="position: relative; overflow: hidden;border: 2px #3f4a7d solid;">
             <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2981.1265586288473!2d44.90464320000002!3d41.6820417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40440e0c27993b55%3A0x185f017fb75863e!2s7%20Abel%20Enukidze%20St%2C%20T&#39;bilisi!5e0!3m2!1sen!2sge!4v1781078795622!5m2!1sen!2sge" width="100%" height="334" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="overlaybox overlaybox-side">
            <div class="container content">
                <div class="row">
                    <div class="col-md-6"></div>
                    {{-- <div class="col-md-6 overlaybox-inner box-middle" style="margin-top: 108px;">
                        <h2 class="text-color text-normal">Contact.</h2>
                        <h2 class="text-normal">Collins Street<br>8007, San Francisco<br>United states</h2>
                        <hr class="space m">
                        <p class="text-normal">
                            1-800-405-377<br>info@company.com<br>Mon - Sat: 8.00 - 19:00
                        </p>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">

        <div class="row vertical-row">
            <div class="col-md-12 boxed white">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="fa-ul text-light">
                            <li><i class="fa-li fa fa-map-marker"></i> {{ __('other.contact_address') }}</li>
                            <li><i class="fa-li fa fa-calendar "></i> {{ __('other.workdays') }} 10.00 - 18.00</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="fa-ul text-light">
                            <li><i class="fa-li fa fa-envelope-o"></i> info@ef-s.ge</li>
                            <li><i class="fa-li fa fa-phone "></i> +995 591 51 61 83</li>
                        </ul>
                    </div>
                </div>
                <hr class="space m">
                <form action="#" class="form-box form-ajax" method="post" data-email="federico@pixor.it">
                    <div class="row">
                        <div class="col-md-6">
                            <input id="name" name="name" placeholder="{{ __('other.contact_form.name') }}"
                                type="text" class="form-control form-value" required="">
                        </div>
                        <div class="col-md-6">
                            <input id="email" name="email" placeholder="{{ __('other.contact_form.email') }}"
                                type="email" class="form-control form-value" required="">
                        </div>
                    </div>
                    <hr class="space xs">
                    <div class="row">
                        <div class="col-md-12">
                            <textarea id="messagge" name="messagge" placeholder="{{ __('other.contact_form.comment') }}"
                                class="form-control form-value" required=""></textarea>
                            <hr class="space s">
                            <button class="btn-sm btn" type="submit"><i class="fa fa-envelope-o"></i>Send
                                messagge</button>
                        </div>
                    </div>
                    <div class="success-box">
                        <div class="alert alert-success">Congratulations. Your message has been sent successfully</div>
                    </div>
                    <div class="error-box">
                        <div class="alert alert-warning">Error, please retry. Your message has not been sent</div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

{{-- <div class="section-bg-color">
    <div class="container content">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="row">
                    <div class="col-md-4 ">
                        <div class="advs-box niche-box-team" data-anima="scale-up" data-trigger="hover">
                            <a class="img-box">
                                <img class="anima" src="/images/user-16.jpg" alt="">
                            </a>
                            <div class="content-box">
                                <h2>Jessica Larry</h2>
                                <h4>Founder</h4>
                                <hr class="e">
                                <div class="btn-group social-group">
                                    <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                    <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                    <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                                <p>Nibh atque suspendisse netus veritatis eveniet pariaturo.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="advs-box niche-box-team" data-anima="scale-up" data-trigger="hover">
                            <a class="img-box">
                                <img class="anima" src="/images/user-17.jpg" alt="">
                            </a>
                            <div class="content-box">
                                <h2>Casey Neistat</h2>
                                <h4>Project manager</h4>
                                <hr class="e">
                                <div class="btn-group social-group">
                                    <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                    <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                    <a target="_blank" href="#"><i class="fa fa-linkedin"></i></a>
                                </div>
                                <p>Nibh atque suspendisse netus veritatis eveniet pariaturo.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="advs-box niche-box-team" data-anima="scale-up" data-trigger="hover">
                            <a class="img-box">
                                <img class="anima" src="/images/user-15.jpg" alt="">
                            </a>
                            <div class="content-box">
                                <h2>Sarah Rodrigo</h2>
                                <h4>Administration</h4>
                                <hr class="e">
                                <div class="btn-group social-group">
                                    <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                    <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                    <a target="_blank" href="#"><i class="fa fa-linkedin"></i></a>
                                </div>
                                <p>Nibh atque suspendisse netus veritatis eveniet pariaturo.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="title-base text-left">
                    <hr>
                    <h2>Funny people</h2>
                    <p>People behind the company</p>
                </div>
                <p>
                    Tincidunt integer eu augue augue nunc elit dolor, luctus placerat scelerisque euismod, iaculis eu
                    lacus nunc mi elito
                    vehicula ut laoreet ac, aliquam sit amet justo nunc tempor, metus velo atque suspendisse netus
                    verita.
                </p>
                <hr class="space s">
                <div class="row">
                    <div class="col-md-6">
                        <div class="icon-box icon-box-top-bottom counter-box-icon text-left">
                            <div class="icon-box-cell">
                                <b><label class="counter text-l" data-speed="2000" data-to="60">60</label></b>
                                <p class="text-s">Team memebers</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="icon-box icon-box-top-bottom counter-box-icon text-left">
                            <div class="icon-box-cell">
                                <b><label class="counter text-l" data-speed="2000" data-to="2000">2000</label></b>
                                <p class="text-s">Monthly clients</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="space m">
                <a href="#" class="btn btn-lg">View all members</a>
            </div>
        </div>
    </div>
</div> --}}

<i class="scroll-top scroll-top-mobile show fa fa-sort-asc" style="opacity: 0;"></i>
<style>
    .flexslider li picture>img {
        width: 100%;
        display: block;
    }

    .scale-up-center {
        opacity: 1;
        animation: scale-up-center 2s cubic-bezier(.39, .575, .565, 1.000) both
    }

    .slide-bottom {
        animation: slide-bottom 2s cubic-bezier(.25, .46, .45, .94) both
    }

    .slide-right {
        opacity: 1;
        animation: slide-right 1.5s cubic-bezier(.25, .46, .45, .94) 1.5s both
    }

    @keyframes slide-right {
        0% {
            transform: translateX(0)
        }

        100% {
            transform: translateX(100px)
        }
    }

    @keyframes scale-up-center {
        0% {
            transform: scale(.5)
        }

        100% {
            transform: scale(1)
        }
    }

    @keyframes slide-bottom {
        0% {
            transform: translateY(-100px)
        }

        100% {
            transform: translateY(0px)
        }
    }

    .animate__animated.animate__fadeInLeft {
        --animate-duration: 700ms;
        --animate-delay: 600ms;
        -webkit-animation-delay: 600ms;

    }

    .animate__animated.animate__fadeInRight {
        --animate-duration: 900ms;
        --animate-delay: 700ms;
        -webkit-animation-delay: 700ms;
    }

    .footer-anim {
        opacity: 0;
    }

    @media (max-width: 992px) {

        .fadedown,
        .map-contact-anim {
            opacity: 1 !important;
        }
    }

    @media (min-width:993px) {
        /* დიზაინერის დავალებით, მოკროპვა უნდოდა და იყოს ჰა */
        /* .section-slider > .flexslider .flex-viewport {
            margin-top: -5.3%;
            margin-bottom: -5.5%;
        } */
    }

    .advanced-slider {
        -webkit-animation: fadein 2.4s;
        /* Safari, Chrome and Opera > 12.1 */
        -moz-animation: fadein 2.4s;
        /* Firefox < 16 */
        -ms-animation: fadein 2.4s;
        /* Internet Explorer */
        -o-animation: fadein 2.4s;
        /* Opera < 12.1 */
        animation: fadein 2.4s;
    }

    @keyframes fadein {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>
<script>
    //home-parallax



    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        let nowparallaxsrc = $('.parallax-window').attr('data-image-src');
        if (nowparallaxsrc) {
            let newparallaxsrc = nowparallaxsrc.replace('home-parallax', 'home-parallax-mobile');
            $('.parallax-window').attr('data-image-src', newparallaxsrc);
        }
    }






    $(window).scroll(function() {
        addClassWhenScreen('home-head-texts-left', 'animate__animated animate__fadeInLeft');
        addClassWhenScreen('home-head-texts-right', 'animate__animated animate__fadeInRight');
        addClassWhenScreen('fadedown', 'animate__animated animate__fadeInDown');
        addClassWhenScreen('fade2', 'scale-up-center');
        addClassWhenScreen('map-contact-anim', 'animate__animated animate__fadeInUp');
        addClassWhenScreen('footer-anim', 'animate__animated animate__fadeInUp');
    });
</script>
@include('layouts.footer')
