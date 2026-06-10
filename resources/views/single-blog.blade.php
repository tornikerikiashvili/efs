@include('layouts.header',[
    'services' => $cat = App\Models\Services::select('id','name_'.app()->getLocale())->where('status',1)->get(),
    'localeSwitchEntity' => $single,
])
<div class="section-empty section-item">
    <div class="container content">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <h1>{{$single['name_'.app()->getLocale()]}}</h1>
                <hr class="space xs">
                <div class="tag-row">
                    <span><i class="fa fa-calendar"></i> <a href="#">{{$single['created_at']}}</a></span>
                </div>
                <br>
                <hr class="space m">
                <a class="img-box" href="#">
                    <img src="{{$single->getFirstMediaUrl('main')}}" alt="">
                </a>
                <hr class="space m">
                <p>
                    {!!$single->trixRender('content_'.app()->getLocale())!!}
                </p>
                <hr class="space visible-sm">
            </div>
            <div class="col-md-4 col-sm-12 boxed-inverse shadow-2">
                <div class="list-group latest-post-list list-blog">
                    <p class="list-group-item active">Latest posts</p>
                    @foreach($blogs as $n)
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="img-box circle">
                                    <img src="{{$n->getFirstMediaUrl('main')}}" alt="">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <a href="{{ route('singleblog', ['slug' => $n->slugForLocale()]) }}">
                                    <h5>{{$n['name_'.app()->getLocale()]}}</h5>
                                </a>
                                <div class="tag-row icon-row"><span><i class="fa fa-calendar"></i>{{$n['created_at']}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
