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
                    {{-- <span><i class="fa fa-bookmark"></i> <a href="#">Travel</a></span>
                    <span><i class="fa fa-pencil"></i><a href="#">Admin</a></span> --}}
                </div>
                <br>
                <p style="font-size: 16px">
                    {!!$single['description']!!}
                </p>
                <hr class="space m">
                <a class="img-box" href="#">
                    <img src="{{$single->getFirstMediaUrl('main')}}" alt="{{ e($single->imageAltForLocale()) }}">
                </a>
                <hr class="space m">
                <div class="rich-text-content">
                    {!! $single->trixRender('content_'.app()->getLocale()) !!}
                </div>
                <hr class="space visible-sm">
            </div>
            <div class="col-md-4 col-sm-12 boxed-inverse shadow-2">
                <div class="list-group latest-post-list list-blog">
                    {{-- <div class="list-group list-blog">
                        <p class="list-group-item active">Categories</p>
                        <a href="#" class="list-group-item">Consutrction</a>
                        <a href="#" class="list-group-item">Buildings</a>
                        <a href="#" class="list-group-item">Interior design</a>
                        <a href="#" class="list-group-item">Outdoor and gardening</a>
                    </div> --}}
                    <p class="list-group-item active">Latest posts</p>
                    @foreach($news as $n)
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="img-box circle">
                                    <img src="{{$n->getFirstMediaUrl('main')}}" alt="{{ e($n->imageAltForLocale()) }}">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <a href="{{ route('singlenews', ['slug' => $n->slugForLocale()]) }}">
                                    <h5>{{$n['name_'.app()->getLocale()]}}</h5>
                                </a>
                                <div class="tag-row icon-row"><span><i class="fa fa-calendar"></i>{{$n['created_at']}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <hr class="space m">
                    <div class="btn-group social-group">
                        <a target="_blank" href="https://www.facebook.com/HSSEQmanagement" data-social="share-facebook" data-toggle="tooltip"
                            data-placement="top" title="Facebook"><i class="fa fa-facebook text-s circle"></i></a>
                        <a target="_blank" href="#" data-social="share-twitter" data-toggle="tooltip"
                            data-placement="top" title="Twitter"><i class="fa fa-twitter text-s circle"></i></a>
                        <a target="_blank" href="#" data-social="share-google" data-toggle="tooltip"
                            data-placement="top" title="Google+"><i class="fa fa-google-plus text-s circle"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')