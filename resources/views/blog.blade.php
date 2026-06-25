@include('layouts.header',['services' => $cat = App\Models\Services::select('id','name_'.app()->getLocale())->where('status',1)->get()])
<div class="header-base">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="title-base text-left">
                    <h1>{{ __('menu.blog') }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section-empty">
    <div class="container content">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="grid-list one-row-list">
                    <div class="grid-box">
                        @foreach($blogs as $n)
                            <div class="grid-item" style="display: block;">
                                <div class="advs-box advs-box-top-icon-img niche-box-post" data-anima="scale-rotate"
                                    data-trigger="hover">
                                    <div class="block-infos">
                                        <div class="block-data">
                                            <p class="bd-day">{{$n['created_at']}}</p>
                                        </div>
                                    </div>
                                    <a class="img-box" href="{{ route('singleblog', ['slug' => $n->slugForLocale()]) }}"><img class="anima" src="{{ $n->getFirstMediaUrl('main') }}" alt="{{ e($n->imageAltForLocale()) }}"></a>
                                    <div class="advs-box-content">
                                        <h2><a href="{{ route('singleblog', ['slug' => $n->slugForLocale()]) }}">{{$n['name_'.app()->getLocale()]}}</a></h2>
                                        <p class="niche-box-content">
                                            {!!$n->trixRender('short_content_'.app()->getLocale())!!}
                                        </p>
                                    </div>
                                </div>
                                <hr class="space m">
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr class="space visible-sm">
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
