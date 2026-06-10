@include('layouts.header', [
    'services' => ($cat = App\Models\Services::select('id', 'name_' . app()->getLocale())->where('status', 1)->get()),
])
<div class="header-base">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="title-base text-left">
                    <h1>{{ __('menu.services') }}</h1>
                    {{-- <p>Services and skills of the Yellow Business and business company.</p> --}}
                </div>
            </div>
            {{-- <div class="col-md-3">
                <ol class="breadcrumb b white">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Pages</a></li>
                    <li class="active">Services</li>
                </ol>
            </div> --}}
        </div>
    </div>
</div>
<div class="section-empty section-item">
    <div class="container content">

        @foreach ($services as $service)
            <div class="row fade_effect slide-effect single-service">
                <div class="col-md-5">
                    <img src="{{ $service->getFirstMediaUrl('main') }}" alt="" loading="lazy">
                </div>
                <div class="col-md-7">
                    <div class="title-base text-left"  id="scrollhere-{{ $service['id'] }}">
                        <hr>
                        <h2>{{ $service['name_' . app()->getLocale()] }}</h2>
                        <p>{{ $service['description'] }}</p>
                    </div>
                    @php
                        if (!empty($service->trixRender('short_content_' . app()->getLocale()))) {
                            $content = $service->trixRender('short_content_' . app()->getLocale());
                        } else {
                            $content = $service->trixRender('content_' . app()->getLocale());
                        }
                    @endphp


                    @if (strlen($content) > 3000)
                        <div class="read-more">
                            {!! $content !!}
                        </div>
                        <a href="#" class="readmoreclick">... {{ __('other.read_more') }}</a>
                    @else
                        <div>
                            {!! $content !!}
                            {{-- {{ $service['content_'.app()->getLocale()] }} --}}
                        </div>
                    @endif

                    <hr class="space s">
                    <div class="row vertical-row">
                        <div class="col-md-9 ">
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('singleservice', ['slug' => $service->slug, 'id' => $service->id]) }}"
                                class="circle-button btn-border btn btn-sm nav-justified">{{ __('other.readmore') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="space">
        @endforeach

    </div>
</div>
<style>
    .read-more {
        max-height: 220px;
        overflow: hidden;
        -webkit-mask-image: linear-gradient(180deg, #000 70%, transparent);
    }

    .single-service {
        scroll-margin-bottom: 300px;
        /* scroll-margin: 500px; */
    }

    @media (min-width: 994px) {
        .single-service:nth-of-type(odd) {
            /* background: #00f5f5; */
            display: flex;
            flex-direction: row-reverse;
        }

        .fade_effect {
            opacity: 0;
        }

        .slide-right {
            -webkit-animation: slide-right 1s cubic-bezier(.25, .46, .45, .94) both;
            animation: slide-right 1s cubic-bezier(.25, .46, .45, .94) both
        }

        .slide-top {
            -webkit-animation: slide-top 1s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
            animation: slide-top 1s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        }

        .slide-left {
            -webkit-animation: slide-left 1s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
            animation: slide-left 1s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        }

        @-webkit-keyframes slide-top {
            0% {
                -webkit-transform: translateY(0);
                transform: translateY(0)
            }

            100% {
                -webkit-transform: translateY(-100px);
                transform: translateY(-100px)
            }
        }

        @keyframes slide-top {
            0% {
                -webkit-transform: translateY(0);
                transform: translateY(0)
            }

            100% {
                -webkit-transform: translateY(-100px);
                transform: translateY(-100px)
            }
        }

        @-webkit-keyframes slide-right {
            0% {
                -webkit-transform: translateX(0);
                transform: translateX(0)
            }

            100% {
                -webkit-transform: translateX(100px);
                transform: translateX(100px)
            }
        }

        @keyframes slide-right {
            0% {
                -webkit-transform: translateX(0);
                transform: translateX(0)
            }

            100% {
                -webkit-transform: translateX(100px);
                transform: translateX(100px)
            }
        }

        @-webkit-keyframes slide-left {
            0% {
                -webkit-transform: translateX(0);
                transform: translateX(0)
            }

            100% {
                -webkit-transform: translateX(-100px);
                transform: translateX(-100px)
            }
        }

        @keyframes slide-left {
            0% {
                -webkit-transform: translateX(0);
                transform: translateX(0)
            }

            100% {
                -webkit-transform: translateX(-100px);
                transform: translateX(-100px)
            }
        }
    }

    .content {
        padding-top: 150px !important;
    }
</style>
<script>
     if (window.location.hash) {
        var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
        document.querySelector("#scrollhere-" + hash).scrollIntoView(true);
        document.querySelector("#scrollhere-" + hash).scrollIntoView({
            behavior: 'smooth',
            block: "center"
        });

        // $('html, body').animate({
        //     scrollTop: scrollOptional
        // }, 1000);
    }
    $(document).ready(function() {
       

        $(".readmoreclick").click(function() {
            $(this).closest('div').find('.read-more').removeClass('read-more')
            $(this).remove();
        });



        function showMore() {
            //removes the link
            document.getElementById('link').parentElement.removeChild('link');
            //shows the #more
            document.getElementById('more').style.display = "block";
        }
    });

    if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $(window).scroll(function() {
            var windowBottom = $(this).scrollTop() + $(this).innerHeight() + 300;
            $(".fade_effect").each(function() {
                /* Check the location of each desired element */
                var objectBottom = $(this).offset().top + $(this).outerHeight();

                /* If the element is completely within bounds of the window, fade it in */
                if (objectBottom < windowBottom) { //object comes into view (scrolling down)
                    if ($(this).css("opacity") == 0) {
                        $(this).fadeTo(500, 1).addClass('slide-top');
                    }
                } else { //object goes out of view (scrolling up)
                    // if ($(this).css("opacity")==0) {$(this).fadeTo(500,1);}
                }
            });
        }).scroll(); //invoke scroll-handler on page-load
    }
</script>
@include('layouts.footer')
