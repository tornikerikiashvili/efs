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
            {{-- <div class="col-md-4 col-sm-6">

                <img src="../images/image-15.jpeg" alt="" style="margin-top: -1px;">

                <hr class="space m">
                <div class="advs-box advs-box-side-icon" data-anima="fade-top" data-trigger="hover">
                    <div class="icon-box">
                        <i class="fa fa-medkit icon anima" aid="0.5301694350503225"
                            style="position: relative; transition-duration: 500ms; animation-duration: 500ms; transition-timing-function: ease; transition-delay: 0ms;"></i>
                    </div>
                    <div class="caption-box">
                        <h3>Mountain and outdoor</h3>
                        <p>
                            Interdum iusto pulvinar consequuntur augue optio, repellat fugrus expedinisi ut aliquip ex
                            ea commodo consequatta fusce temporibus est odit mi quo iquid sempere veritatis dignissimoso
                            pertillio.
                        </p>
                    </div>
                </div>
                <hr class="space visible-xs">
            </div> --}}
            <div class="col-md-8 col-sm-8">
                <div class="advs-box advs-box-side-icon">
                    {{-- <div class="icon-box">
                        <i class="fa fa-road icon anima"></i>
                    </div> --}}
                    <div class="caption-box">
                        <h3>{{ takeText($about,'headline2') }}</h3>
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
        {{-- <p class="block-quote quote-1 quote-gray">
            {{ __('about.about.footertext') }}
        </p> --}}
    </div>
</div>
@include('layouts.footer')
