@extends('argon.layouts.app')

@section('content')
    @include('argon.layouts.headers.cards')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-10 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header border-0">
                        <h3 class="mb-0">{{ $label }}</h3>
                        <p class="text-muted mb-0 mt-2">File: <code>{{ $group }}.php</code></p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('translations.update', $group) }}" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <x-forms.locale-tabs id="translations-locale">
                                <x-slot name="ka">
                                    @foreach ($keys as $index => $key)
                                        <input type="hidden" name="rows[{{ $index }}][key]" value="{{ $key }}">
                                        <div class="form-group">
                                            <label class="form-control-label text-muted small">{{ $key }}</label>
                                            @if ($key === 'map_embed')
                                                <p class="text-muted small mb-2">Paste the full Google Maps iframe HTML or only the embed URL.</p>
                                            @endif
                                            @if (strlen($values['ka'][$key] ?? '') > 120 || $key === 'map_embed')
                                                <textarea class="form-control" rows="4" name="rows[{{ $index }}][ka]">{{ old('rows.'.$index.'.ka', $values['ka'][$key] ?? '') }}</textarea>
                                            @else
                                                <input type="text" class="form-control" name="rows[{{ $index }}][ka]" value="{{ old('rows.'.$index.'.ka', $values['ka'][$key] ?? '') }}">
                                            @endif
                                        </div>
                                        <hr>
                                    @endforeach
                                </x-slot>

                                <x-slot name="en">
                                    @foreach ($keys as $index => $key)
                                        <div class="form-group">
                                            <label class="form-control-label text-muted small">{{ $key }}</label>
                                            @if ($key === 'map_embed')
                                                <p class="text-muted small mb-2">Paste the full Google Maps iframe HTML or only the embed URL.</p>
                                            @endif
                                            @if (strlen($values['en'][$key] ?? '') > 120 || $key === 'map_embed')
                                                <textarea class="form-control" rows="4" name="rows[{{ $index }}][en]">{{ old('rows.'.$index.'.en', $values['en'][$key] ?? '') }}</textarea>
                                            @else
                                                <input type="text" class="form-control" name="rows[{{ $index }}][en]" value="{{ old('rows.'.$index.'.en', $values['en'][$key] ?? '') }}">
                                            @endif
                                        </div>
                                        <hr>
                                    @endforeach
                                </x-slot>
                            </x-forms.locale-tabs>

                            <div class="text-center">
                                <a href="{{ route('translations.index') }}" class="btn btn-secondary mt-4">Back</a>
                                <button type="submit" class="btn btn-success mt-4">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
