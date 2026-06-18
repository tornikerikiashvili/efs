@extends('argon.layouts.app')

@section('content')
    @include('argon.layouts.headers.cards')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-10 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header border-0">
                        <h3 class="mb-0">SEO & OG</h3>
                        <p class="text-muted mb-0 mt-2">
                            Enter exact meta and Open Graph values for each page. Titles are used as written.
                        </p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('site-seo.update') }}" autocomplete="off">
                            @csrf
                            @method('PUT')

                            @foreach ($pages as $pageKey => $pageLabel)
                                <div class="seo-og-section mb-4 p-3 rounded border" style="background-color: #f6f7ff;">
                                    <h6 class="heading-small text-muted mb-3">{{ $pageLabel }}</h6>

                                    <x-forms.locale-tabs :id="'site-seo-' . $pageKey">
                                        <x-slot name="ka">
                                            @foreach ($fields as $fieldKey => $fieldLabel)
                                                <div class="form-group">
                                                    <label class="form-control-label">{{ $fieldLabel }}</label>
                                                    @if ($fieldKey === 'description' || $fieldKey === 'og_description')
                                                        <textarea class="form-control" rows="3" name="pages[{{ $pageKey }}][ka][{{ $fieldKey }}]">{{ old('pages.'.$pageKey.'.ka.'.$fieldKey, data_get($values, 'ka.'.$pageKey.'.'.$fieldKey, '')) }}</textarea>
                                                    @else
                                                        <input type="text" class="form-control" name="pages[{{ $pageKey }}][ka][{{ $fieldKey }}]" value="{{ old('pages.'.$pageKey.'.ka.'.$fieldKey, data_get($values, 'ka.'.$pageKey.'.'.$fieldKey, '')) }}">
                                                    @endif
                                                </div>
                                            @endforeach
                                        </x-slot>

                                        <x-slot name="en">
                                            @foreach ($fields as $fieldKey => $fieldLabel)
                                                <div class="form-group">
                                                    <label class="form-control-label">{{ $fieldLabel }}</label>
                                                    @if ($fieldKey === 'description' || $fieldKey === 'og_description')
                                                        <textarea class="form-control" rows="3" name="pages[{{ $pageKey }}][en][{{ $fieldKey }}]">{{ old('pages.'.$pageKey.'.en.'.$fieldKey, data_get($values, 'en.'.$pageKey.'.'.$fieldKey, '')) }}</textarea>
                                                    @else
                                                        <input type="text" class="form-control" name="pages[{{ $pageKey }}][en][{{ $fieldKey }}]" value="{{ old('pages.'.$pageKey.'.en.'.$fieldKey, data_get($values, 'en.'.$pageKey.'.'.$fieldKey, '')) }}">
                                                    @endif
                                                </div>
                                            @endforeach
                                        </x-slot>
                                    </x-forms.locale-tabs>
                                </div>
                            @endforeach

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
