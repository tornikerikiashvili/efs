@extends('argon.layouts.app')

@section('content')
    @include('argon.layouts.headers.cards')
    <x-rich-editor-assets />
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-body">

                        <form method="POST"
                            action="{{ isset($service) ? route('services.update', ['service' => $service['id']]) : route('services.store') }}"
                            autocomplete="off" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="_method" value="{{ isset($service) ? 'put' : 'post' }}" />

                            <h6 class="heading-small text-muted mb-4">{{ __('Edit Blade') }}</h6>

                            <x-forms.locale-tabs id="services-locale">
                                <x-slot name="ka">
                                    <x-forms.input type="text" name="name_ka" headline="Name"
                                        value="{{ $service['name_ka'] ?? old('name_ka') }}" />
                                    <x-forms.input type="text" name="slug_ka" headline="Slug (optional)"
                                        value="{{ $service['slug_ka'] ?? old('slug_ka') }}" />

                                    <x-forms.seo-og-section locale="ka" :record="$service ?? null" />

                                    <x-forms.rich-editor :model="\App\Models\Services::class" field="short_content_ka" label="Short Content" :height="200" :record="$service ?? null" />
                                    <x-forms.rich-editor :model="\App\Models\Services::class" field="content_ka" label="Full Content" :height="400" :record="$service ?? null" />
                                </x-slot>

                                <x-slot name="en">
                                    <x-forms.input type="text" name="name_en" headline="Name"
                                        value="{{ $service['name_en'] ?? old('name_en') }}" />
                                    <x-forms.input type="text" name="slug_en" headline="Slug (optional)"
                                        value="{{ $service['slug_en'] ?? old('slug_en') }}" />

                                    <x-forms.seo-og-section locale="en" :record="$service ?? null" />

                                    <x-forms.rich-editor :model="\App\Models\Services::class" field="short_content_en" label="Short Content" :height="200" :record="$service ?? null" />
                                    <x-forms.rich-editor :model="\App\Models\Services::class" field="content_en" label="Full Content" :height="400" :record="$service ?? null" />
                                </x-slot>
                            </x-forms.locale-tabs>

                            <div class="pl-lg-4">
                                <div class="fileinput fileinput-new text-center {{ $errors->has('image') ? ' has-danger' : '' }}"
                                    data-provides="fileinput">
                                    <label>MAIN IMAGE</label>
                                    <div class="fileinput-new thumbnail img-raised">
                                        @if ($errors->has('image'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                        @endif
                                        <img src="{{ isset($mediaItems[0]) ? $mediaItems[0]->getUrl() : 'https://winaero.com/blog/wp-content/uploads/2019/09/Photos-app-icon-256-colorful.png' }}"
                                            style="max-width: 600px" alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                                    <div>
                                        <span class="btn btn-raised btn-round btn-default btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image" />
                                        </span>
                                        @if(isset($service) && isset($mediaItems[0]))
                                        <span href="#pablo" onclick="deleteBtn('{{route('imgdelete', ['imgid' => $mediaItems[0]['id']])}}')" class="btn btn-danger btn-round fileinput-exists"
                                            data-dismiss="fileinput">
                                            <i class="fa fa-times"></i> Remove</span>
                                        @endif
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <br>
                                <div class="fileinput fileinput-new text-center {{ $errors->has('icon') ? ' has-danger' : '' }}"
                                    data-provides="fileinput">
                                    <label>ICON</label>
                                    <div class="fileinput-new thumbnail img-raised">
                                        @if ($errors->has('icon'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('icon') }}</strong>
                                            </span>
                                        @endif
                                        <img src="{{ isset($iconmediaItems[0]) ? $iconmediaItems[0]->getUrl() : 'https://winaero.com/blog/wp-content/uploads/2019/09/Photos-app-icon-256-colorful.png' }}"
                                            style="max-width: 200px" alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                                    <div>
                                        <span class="btn btn-raised btn-round btn-default btn-file">
                                            <span class="fileinput-new">Select icon</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="icon" />
                                        </span>
                                        @if(isset($service) && isset($iconmediaItems[0]))
                                        <span href="#pablo" onclick="deleteBtn('{{route('imgdelete', ['imgid' => $iconmediaItems[0]['id']])}}')" class="btn btn-danger btn-round fileinput-exists"
                                            data-dismiss="fileinput">
                                            <i class="fa fa-times"></i> Remove</span>
                                        @endif
                                    </div>
                                </div>
                                <br>
                                <h3>status</h3>
                                <div class="form-check form-check-radio">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="status" id="status1"
                                            value="1"
                                            {{ isset($service) && $service['status'] == 1 ? 'checked' : '' }}>
                                        Show
                                        <span class="circle">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="form-check form-check-radio">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="status" id="status2"
                                            value="0"
                                            {{ isset($service) && $service['status'] == 0 ? 'checked' : '' }}>
                                        Hide
                                        <span class="circle">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endsection

   

    @push('js')
        <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    @endpush
