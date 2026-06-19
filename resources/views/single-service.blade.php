@include('layouts.header',[
    'services' => $cat = App\Models\Services::select('id','name_'.app()->getLocale())->where('status',1)->get(),
    'localeSwitchEntity' => $service,
])
<div class="header-base">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="title-base text-left">
                    <h1>{{ $service['name_'.app()->getlocale()] }}</h1>
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
        <div class="row clearfix">
				
            <!--Content Side-->
            <div class="content-side col-lg-8 col-md-12 col-sm-12">
                <div class="service-detail">
                    <div class="inner-box">
                        <div class="image">
                            <img src="{{($service->getFirstMediaUrl('main')) ? $service->getFirstMediaUrl('main') : ''}}" alt="">
                        </div>
                        <div class="rich-text-content">
                            {!! $service->trixRender('content_'.app()->getLocale()) !!}
                        </div>
                    </div>
                </div>
            </div>
            
            <!--Sidebar Side-->
            <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
                <aside class="sidebar">
                    <div class="sidebar-inner">
                        
                        <!-- Blog Services Widget -->
                        <div class="sidebar-widget sidebar-services-category">
                            <div class="widget-content">
                                <ul class="services-cat">
                                    @foreach($services as $item)
                                        <li class="{{($service->id == $item->id) ? 'active' : '' }}">
                                            <a href="{{ route('singleservice', ['slug' => $item->slugForLocale()]) }}">
                                                <span>{{$item['name_'.app()->getlocale()]}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        
                       
                        
                        <!-- Contact Widget -->
                        {{-- <div class="sidebar-widget contact-widget">
                            <div class="widget-content" style="background-image:url(images/background/pattern-12.png)">
                                <div class="icon flaticon-phone-call"></div>
                                <div class="text">Got any Questions? <br> Call Us Today</div>
                                <div class="number">1-800-369-8527</div>
                                <div class="email">support@solvaconsult.net</div>
                            </div>
                        </div> --}}
                        
                    </div>
                </aside>
            </div>
            
        </div>
        
    </div>
</div>

<style>
    .service-detail {
        font-size: 16px;
    }
    .sidebar-services-category {
        position: relative;
    }
    .sidebar-services-category .widget-content {
        position: relative;
        padding: 0px 35px;
    }
    .sidebar-services-category .widget-content:before {
        position: absolute;
        content: '';
        left: 0px;
        top: 0px;
        right: 0px;
        height: 300px;
        background-color: unset;
    }
    .sidebar-services-category .services-cat {
        padding-left: 0px;
        box-shadow: 0px 0px 10px rgb(0 0 0 / 10%);
    }
    .sidebar-services-category li {
        position: relative;
        margin-bottom: 1px;
        text-align: right;
        transition: all 500ms ease;
        list-style-type: none;  
        -moz-transition: all 500ms ease;
        -webkit-transition: all 500ms ease;
        -ms-transition: all 500ms ease;
        -o-transition: all 500ms ease;
    }
    .sidebar-services-category li:before {
        position: absolute;
        content: '';
        left: 0px;
        top: 0px;
        width: 0px;
        height: 100%;
        z-index: 1;
        transition: all 500ms ease;
        -moz-transition: all 500ms ease;
        -webkit-transition: all 500ms ease;
        -ms-transition: all 500ms ease;
        -o-transition: all 500ms ease;
        background-image: -ms-linear-gradient(left, #3777c9 0%, #1e3450 100%);
        background-image: -moz-linear-gradient(left, #3777c9 0%, #1e3450 100%);
        background-image: -o-linear-gradient(left, #3777c9 0%, #1e3450 100%);
        background-image: -webkit-gradient(linear, left top, right top, color-stop(0, #3777c9), color-stop(100, #1e3450));
        background-image: -webkit-linear-gradient(left, #3777c9 0%, #1e3450 100%);
        background-image: linear-gradient(to right, #3777c9 0%, #1e3450 100%)
    }
    .sidebar-services-category li a {
        position: relative;
        color: #222222;
        font-size: 15px;
        font-weight: 600;
        display: block;
        background-color: #ffffff;
        border-bottom: 1px solid #acacac;
        padding: 20px 32px 16px 38px;
        transition: all 500ms ease;
        -moz-transition: all 500ms ease;
        -webkit-transition: all 500ms ease;
        -ms-transition: all 500ms ease;
        -o-transition: all 500ms ease;
    }
    .sidebar-services-category li a:before {
        position: absolute;
        content: '\f0d9';
        left: 22px;
        top: 18px;
        color: #1e3450;
        font-size: 18px;
        z-index: 1;
        font-family: 'FontAwesome';
        transition: all 500ms ease;
        -moz-transition: all 500ms ease;
        -webkit-transition: all 500ms ease;
        -ms-transition: all 500ms ease;
        -o-transition: all 500ms ease;
    }
    .sidebar-services-category li a span {
        position: relative;
        z-index: 1;
        transition: all 500ms ease;
        -moz-transition: all 500ms ease;
        -webkit-transition: all 500ms ease;
        -ms-transition: all 500ms ease;
        -o-transition: all 500ms ease;
    }
    .sidebar-services-category li:hover::before, .sidebar-services-category li.active::before {
        width: 100%;
    }
    .sidebar-services-category li.active a, .sidebar-services-category li a:hover {
        color: #ffffff;
    }
    .sidebar-services-category li.active a:before, .sidebar-services-category li:hover a::before {
        color: #ffffff;
    }
    .sidebar-services-category li.active a span, .sidebar-services-category li:hover a span {
        color: #ffffff;
    }
</style>

<script>
    
        
</script>
@include('layouts.footer')
