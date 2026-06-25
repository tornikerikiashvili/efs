@include('layouts.header',['services' => $cat = App\Models\Services::select('id','name_'.app()->getLocale())->where('status',1)->get()])
<div class="header-base">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="title-base text-left">
                    <h1>{{ __('menu.news') }}</h1>
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
                        @foreach($news as $n)
                            <div class="grid-item" style="display: block;">
                                <div class="advs-box advs-box-top-icon-img niche-box-post" data-anima="scale-rotate"
                                    data-trigger="hover">
                                    <div class="block-infos">
                                        <div class="block-data">
                                            <p class="bd-day">{{$n['created_at']}}</p>
                                        </div>
                                        <a class="block-comment" href="#">2 <i class="fa fa-comment-o"></i></a>
                                    </div>
                                    <a class="img-box" href="{{ route('singlenews', ['slug' => $n->slugForLocale()]) }}"><img class="anima" src="{{ $n->getFirstMediaUrl('main') }}" alt="{{ e($n->imageAltForLocale()) }}"
                                            style="margin-top: -34px; position: relative; transition-duration: 500ms; animation-duration: 500ms; transition-timing-function: ease; transition-delay: 0ms;"
                                            aid="0.5357019905551677"></a>
                                    <div class="advs-box-content">
                                        <h2><a href="{{ route('singlenews', ['slug' => $n->slugForLocale()]) }}">{{$n['name_'.app()->getLocale()]}}</a></h2>
                                        <div class="tag-row">
                                            {{-- <span><i class="fa fa-bookmark"></i> <a href="#">Business</a>, <a
                                                    href="#">Financial</a></span>
                                            <span><i class="fa fa-pencil"></i><a>Admin</a></span> --}}
                                        </div>
                                        <p class="niche-box-content">
                                            {!!$n->trixRender('short_content_'.app()->getLocale())!!}
                                        </p>
                                    </div>
                                </div>
                                <hr class="space m">
                            </div>
                        @endforeach
                    </div>
                    <x-list-pagination :paginator="$news" />
                </div>
                <hr class="space visible-sm">
            </div>
            {{-- <div class="col-md-4 col-sm-12 boxed-inverse shadow-2">
                <h2 class="text-normal text-m">Twitter feeds</h2>
                <p class="no-margins text-color">Latest news from our best and most followed social network.</p>
                <hr class="space m">
                <div class="social-feed-tw" data-social-id="CGT_Caterpillar"
                    data-options="minWidth:250,show_media:false,limit:13">
                    <ul></ul>
                </div>
                <hr class="space m">
                <a href="#" class="btn btn-sm">Twitter official</a>
            </div> --}}
        </div>
    </div>
</div>
@include('layouts.footer')
