@extends('argon.layouts.app')

@section('content')
    @include('argon.layouts.headers.cards')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-body">
                        <form method="POST"
                            action="{{ isset($partner) ? route('partner-logos.update', ['partner_logo' => $partner->id]) : route('partner-logos.store') }}"
                            autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="{{ isset($partner) ? 'put' : 'post' }}" />

                            <h6 class="heading-small text-muted mb-4">Partner logo</h6>

                            <x-forms.input type="text" name="name" headline="Partner name (admin label)" value="{{ $partner->name ?? old('name') }}" />
                            <x-forms.input type="url" name="url" headline="Website URL (optional)" value="{{ $partner->url ?? old('url') }}" />
                            <x-forms.input type="number" name="sort_order" headline="Sort order" value="{{ $partner->sort_order ?? old('sort_order', 0) }}" />

                            <div class="fileinput fileinput-new text-center {{ $errors->has('image') ? ' has-danger' : '' }}" data-provides="fileinput">
                                <div class="fileinput-new thumbnail img-raised">
                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                    <img src="{{ isset($mediaItems[0]) ? $mediaItems[0]->getUrl() : 'https://winaero.com/blog/wp-content/uploads/2019/09/Photos-app-icon-256-colorful.png' }}"
                                        style="max-width: 300px"
                                        alt="{{ e(isset($partner) ? $partner->imageAltForLocale('ka') : '') }}">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                                <div>
                                    <span class="btn btn-raised btn-round btn-default btn-file">
                                        <span class="fileinput-new">Select logo</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="image" accept="image/*" />
                                    </span>
                                    @if (isset($partner) && isset($mediaItems[0]))
                                        <span onclick="deleteBtn('{{ route('imgdelete', ['imgid' => $mediaItems[0]['id']]) }}')" class="btn btn-danger btn-round fileinput-exists"
                                            data-dismiss="fileinput">
                                            <i class="fa fa-times"></i> Remove
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <x-forms.image-alt-fields :record="$partner ?? null" />

                            <br><br>

                            <h3>Status</h3>
                            <div class="form-check form-check-radio">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="status" value="1" {{ (!isset($partner) || $partner->status == 1) ? 'checked' : '' }}>
                                    Show
                                    <span class="circle"><span class="check"></span></span>
                                </label>
                            </div>
                            <div class="form-check form-check-radio">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="status" value="0" {{ (isset($partner) && $partner->status == 0) ? 'checked' : '' }}>
                                    Hide
                                    <span class="circle"><span class="check"></span></span>
                                </label>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
