@include('layouts.header', [
    'services' => $cat = App\Models\Services::select('id', 'name_' . app()->getLocale())->where('status', 1)->get(),
    'seo' => $seo ?? [],
])
<div class="header-base">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="title-base text-left">
                    <h1>{{ __('other.search') }}</h1>
                    @if ($q !== '')
                        <p>{{ __('other.search_results_for', ['query' => $q]) }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section-empty">
    <div class="container content">
        <div class="row">
            <div class="col-md-10 col-sm-12">
                @if ($q === '')
                    <p>{{ __('other.search_prompt') }}</p>
                @elseif ($results->isEmpty())
                    <p>{{ __('other.search_no_results', ['query' => $q]) }}</p>
                @else
                    <div class="grid-list one-row-list">
                        <div class="grid-box">
                            @foreach ($results as $result)
                                <div class="grid-item" style="display: block;">
                                    <div class="advs-box advs-box-top-icon-img niche-box-post">
                                        @if ($result->image)
                                            <a class="img-box" href="{{ $result->url }}">
                                                <img class="anima" src="{{ $result->image }}" alt="{{ e($result->alt) }}">
                                            </a>
                                        @endif
                                        <div class="advs-box-content">
                                            <p class="text-s text-color"><span class="label label-default">{{ $result->type }}</span></p>
                                            <h2><a href="{{ $result->url }}">{{ $result->title }}</a></h2>
                                            <a class="btn-text" href="{{ $result->url }}">{{ __('other.readmore') }}</a>
                                        </div>
                                    </div>
                                    <hr class="space m">
                                </div>
                            @endforeach
                        </div>
                        <x-list-pagination :paginator="$results" />
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
