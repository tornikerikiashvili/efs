@include('layouts.header',['services' => $cat = App\Models\Services::select('id','name_'.app()->getLocale())->where('status',1)->get()])
<div class="section-empty">
    <div class="container content">
        <h1>{{ __('about.about.about_us') }}</h1>
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <p>
                    {{ takeText($about,'subtext') }}
                </p>
                <ul class="fa-ul">
                    @php
                        $services = App\Models\Services::select('id','name_'.app()->getLocale())->where('status',1)->get()
                    @endphp
                    @foreach($services as $item)
                        <li><i class="fa-li fa fa-square"></i>{{$item['name_'.app()->getLocale()]}}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-8 col-sm-8">
                <div class="advs-box advs-box-side-icon">
                    <div class="caption-box">
                        <h2>{{ takeText($about,'headline2') }}</h2>
                        <p>
                            {{ takeText($about,'secondsubtext') }}
                        </p>
                        @php
                            $secondsubitems = takeText($about,'secondsubitems');
                            if (str_contains($secondsubitems, '*')) {
                                $secondsubitems = explode('*', $secondsubitems);
                                foreach ($secondsubitems as $value) {
                                    if(!$value) continue;
                                    echo '<li><i class="fa-li fa fa-square"></i>
                                            '.$value.'
                                        </li>';
                                }
                            }
                        @endphp
                    </div>
                </div>
                <hr class="space m">
                <img src="{{$about[0]->getFirstMediaUrl('about_image')}}" alt="" style="margin-top: -1px;">
            </div>
        </div>

        <hr class="space s">
        <hr>
        <hr class="space s">

        <div class="about-block" id="misia">
            <h2 class="about-block-title">{{ takeText($aboutSections,'mission') }}</h2>
            <p>{{ takeText($aboutSections,'mission_text') }}</p>
        </div>

        <hr class="space s">

        <div class="about-block" id="mizani">
            <h2 class="about-block-title">{{ takeText($aboutSections,'goal') }}</h2>
            <p>{{ takeText($aboutSections,'goal_text') }}</p>
        </div>

        <hr class="space s">

        <div class="about-block" id="girebulebebi">
            <h2 class="about-block-title">{{ takeText($aboutSections,'values') }}</h2>
            <p>{{ takeText($aboutSections,'values_text') }}</p>
        </div>

        @if ($teamMembers->isNotEmpty())
            <hr class="space s">
            <hr>
            <hr class="space s">

            <div class="about-block" id="team">
                <h2 class="about-block-title">{{ __('about.team_title') }}</h2>
                <div class="row">
                    @foreach ($teamMembers as $member)
                        <div class="col-md-4 col-sm-6">
                            <div class="advs-box niche-box-team team-member-card">
                                <div class="img-box">
                                    <img src="{{ $member->getFirstMediaUrl('main') }}" alt="{{ e($member->imageAltForLocale()) }}">
                                </div>
                                <div class="content-box">
                                    <h3>{{ $member['name_'.app()->getLocale()] }}</h3>
                                    <h4>{{ $member['position_'.app()->getLocale()] }}</h4>
                                </div>
                            </div>
                            <hr class="space m">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <hr class="space s">
    </div>
</div>
<style>
    .about-block-title {
        font-weight: bold;
        color: #707070;
        margin-bottom: 15px;
    }

    .about-block {
        scroll-margin-top: 120px;
    }

    #team .team-member-card {
        padding-bottom: 0;
        overflow: visible;
    }

    #team .team-member-card .content-box {
        position: static;
        height: auto;
        margin-top: 0;
        transition: none;
    }

    #team .team-member-card:hover .content-box {
        margin-top: 0;
        height: auto;
    }

    #team .team-member-card .img-box img,
    #team .team-member-card:hover .img-box img {
        transform: none !important;
        transition: none !important;
    }
</style>
<script>
    $(document).ready(function() {
        if (!window.location.hash) {
            return;
        }

        var target = document.querySelector(window.location.hash);
        if (!target) {
            return;
        }

        $('html, body').animate({
            scrollTop: $(target).offset().top - 120
        }, 1000);
    });
</script>
@include('layouts.footer')
