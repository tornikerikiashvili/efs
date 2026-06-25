@include('layouts.header',[
    'services' => $cat = App\Models\Services::select('id','name_'.app()->getLocale())->where('status',1)->get(),
    'localeSwitchEntity' => $single,
])
<div class="header-base">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="title-base text-left">
                    <h1>{{ $single['name_'.app()->getLocale()] }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section-empty section-item">
    <div class="container content">
        <div class="row clearfix">
            <div class="content-side col-lg-8 col-md-12 col-sm-12">
                <div class="service-detail">
                    <div class="inner-box">
                        <div class="image">
                            <img src="{{ $single->getFirstMediaUrl('main') }}" alt="{{ e($single->imageAltForLocale()) }}">
                        </div>
                        <div class="rich-text-content">
                            {!! $single->trixRender('content_'.app()->getLocale()) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
                <aside class="sidebar">
                    <div class="sidebar-inner">
                        <div class="sidebar-widget sidebar-services-category">
                            <div class="widget-content">
                                <p class="list-group-item active">{{ __('menu.projects') }}</p>
                                <ul class="services-cat">
                                    @foreach($projects as $item)
                                        <li class="{{ $single->id == $item->id ? 'active' : '' }}">
                                            <a href="{{ route('singleproject', ['slug' => $item->slugForLocale()]) }}">
                                                <span>{{ $item['name_'.app()->getLocale()] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
