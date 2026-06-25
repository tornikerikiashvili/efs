@include('layouts.header',['services' => $cat = App\Models\Services::select('id','name_'.app()->getLocale())->where('status',1)->get()])
<div class="header-base">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="title-base text-left">
                    <h1>{{ __('menu.projects') }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section-empty section-item">
    <div class="container content">
        <div class="maso-list">
            <div class="navbar navbar-inner">
                <div class="navbar-toggle"><i class="fa fa-bars"></i><span>{{ __('other.menu') }}</span><i class="fa fa-angle-down"></i>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav over ms-minimal inner maso-filters">
                        <li class="current-active active"><a data-filter="maso-item">{{ __('other.projects.allproject') }}</a></li>
                        {{-- <li><a data-filter="cat1">მიმდინარე</a></li>
                        <li><a data-filter="cat2">დასრულებული</a></li> --}}
                        {{-- <li><a data-filter="cat3">Architecture</a></li>
                        <li><a data-filter="cat4">Gardening</a></li>
                        <li><a data-filter="cat5" href="#">Interior design</a></li> --}}
                        <li><a class="maso-order" data-sort="asc"><i class="fa fa-arrow-down"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="maso-box row" data-options="anima:fade-in" style="position: relative; height: 865.61px;">
                @foreach ($projects as $item)
                    <div data-sort="1"
                        class="maso-item col-md-4 col-sm-6  scale-up-center">
                        <div class="advs-box advs-box-multiple boxed-inverse" data-anima="scale-up" data-trigger="hover"
                            style="visibility: visible; opacity: 1;">
                            <a class="img-box" href="{{ route('singleproject', ['slug' => $item->slugForLocale()]) }}" style="opacity: 1;"><img class="anima"
                                    src="{{ $item->getFirstMediaUrl('main') }}"  alt="{{ e($item->imageAltForLocale()) }}"
                                    aid="0.7323773017265196"
                                    style="position: relative; transition-duration: 500ms; animation-duration: 500ms; transition-timing-function: ease; transition-delay: 0ms;"></a>
                            {{-- <div class="circle anima"
                                style="transition-duration: 500ms; animation-duration: 500ms; transition-timing-function: ease; transition-delay: 0ms;"
                                aid="0.9653511579632346"><i class="fa fa-cutlery"></i></div> --}}
                            <div class="advs-box-content" style="opacity: 1;">
                                <h3>
                                    <a href="{{ route('singleproject', ['slug' => $item->slugForLocale()]) }}">
                                        {{ $item['name_'.app()->getLocale()] }}
                                    </a>
                                </h3>
                                <a class="btn-text" href="{{ route('singleproject', ['slug' => $item->slugForLocale()]) }}">{{ __('other.readmore') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="clear"></div>
            </div>
            <x-list-pagination :paginator="$projects" />
            <style>
                .scale-up-center {
                    -webkit-animation: scale-up-center 1s cubic-bezier(.39, .575, .565, 1.000) both;
                    animation: scale-up-center 1s cubic-bezier(.39, .575, .565, 1.000) both
                }

                @-webkit-keyframes scale-up-center {
                    0% {
                        -webkit-transform: scale(.5);
                        transform: scale(.5)
                    }

                    100% {
                        -webkit-transform: scale(1);
                        transform: scale(1)
                    }
                }

                @keyframes scale-up-center {
                    0% {
                        -webkit-transform: scale(.5);
                        transform: scale(.5)
                    }

                    100% {
                        -webkit-transform: scale(1);
                        transform: scale(1)
                    }
                }
            </style>
        </div>
    </div>
</div>
{{-- <script>
    const images = document.getElementsByTagName("img");
    for (let image of images) {
        image.addEventListener("load", fadeImg);
        image.style.opacity = "0";
    }

    function fadeImg() {
        this.style.transition = "opacity 2s";
        this.style.opacity = "1";
    }
</script> --}}
@include('layouts.footer')
