@extends('argon.layouts.app')

@section('content')
    @include('argon.layouts.headers.cards')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-body">
                        <form method="POST"
                            action="{{ isset($member) ? route('team-members.update', ['team_member' => $member->id]) : route('team-members.store') }}"
                            autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="{{ isset($member) ? 'put' : 'post' }}" />

                            <h6 class="heading-small text-muted mb-4">Team member</h6>

                            <x-forms.locale-tabs id="team-member-locale">
                                <x-slot name="ka">
                                    <x-forms.input type="text" name="name_ka" headline="Name" value="{{ $member->name_ka ?? old('name_ka') }}" />
                                    <x-forms.input type="text" name="position_ka" headline="Position" value="{{ $member->position_ka ?? old('position_ka') }}" />
                                </x-slot>

                                <x-slot name="en">
                                    <x-forms.input type="text" name="name_en" headline="Name" value="{{ $member->name_en ?? old('name_en') }}" />
                                    <x-forms.input type="text" name="position_en" headline="Position" value="{{ $member->position_en ?? old('position_en') }}" />
                                </x-slot>
                            </x-forms.locale-tabs>

                            <div class="pl-lg-4">
                                <x-forms.input type="number" name="sort_order" headline="Sort order" value="{{ $member->sort_order ?? old('sort_order', 0) }}" />

                                <div class="fileinput fileinput-new text-center {{ $errors->has('image') ? ' has-danger' : '' }}" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail img-raised">
                                        @if ($errors->has('image'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                        @endif
                                        <img src="{{ isset($mediaItems[0]) ? $mediaItems[0]->getUrl() : 'https://winaero.com/blog/wp-content/uploads/2019/09/Photos-app-icon-256-colorful.png' }}"
                                            style="max-width: 300px"
                                            alt="{{ e(isset($member) ? $member->imageAltForLocale('ka') : '') }}">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                                    <div>
                                        <span class="btn btn-raised btn-round btn-default btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image" />
                                        </span>
                                        @if (isset($member) && isset($mediaItems[0]))
                                            <span onclick="deleteBtn('{{ route('imgdelete', ['imgid' => $mediaItems[0]['id']]) }}')" class="btn btn-danger btn-round fileinput-exists"
                                                data-dismiss="fileinput">
                                                <i class="fa fa-times"></i> Remove
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <x-forms.image-alt-fields :record="$member ?? null" />

                                <br><br>

                                <h3>Status</h3>
                                <div class="form-check form-check-radio">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="status" value="1" {{ (!isset($member) || $member->status == 1) ? 'checked' : '' }}>
                                        Show
                                        <span class="circle"><span class="check"></span></span>
                                    </label>
                                </div>
                                <div class="form-check form-check-radio">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="status" value="0" {{ (isset($member) && $member->status == 0) ? 'checked' : '' }}>
                                        Hide
                                        <span class="circle"><span class="check"></span></span>
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
    </div>
@endsection
