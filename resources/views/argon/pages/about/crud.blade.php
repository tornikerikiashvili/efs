@extends('argon.layouts.app')

@section('content')
    @include('argon.layouts.headers.cards')

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-body">
                        <form method="POST"
                            action="{{ route('about.update', ['about' => $data[0]['page_id']]) }}"
                            autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" />
                            @foreach($data as $key => $item)
                                <input type="hidden" name="rows[{{$key}}][id]" value="{{$item['id']}}">
                                <input type="hidden" name="rows[{{$key}}][text_code]" value="{{$item['text_code']}}">
                                <x-forms.input type="text" disabled name="" 
                                    headline="Text Code" value="{{ $item['text_code'] ?? old('text_code') }}" />
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">Text Ka</label>
                                    <textarea class="form-control" name="rows[{{$key}}][text_ka]">{{$item['text_ka']}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">Text En</label>
                                    <textarea class="form-control" name="rows[{{$key}}][text_en]">{{$item['text_en']}}</textarea>
                                </div>
                                <hr>
                            @endforeach
                            
                            @if($about == 1)
                            <div class="pl-lg-4">
                                <div class="fileinput fileinput-new text-center {{ $errors->has('about_image') ? ' has-danger' : '' }}" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail img-raised">
                                        @if ($errors->has('about_image'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('about_image') }}</strong>
                                            </span>
                                        @endif
                                        <img src="{{($data[0]->getFirstMedia('about_image')) ? $data[0]->getFirstMediaUrl('about_image') : 'https://winaero.com/blog/wp-content/uploads/2019/09/Photos-app-icon-256-colorful.png'}}"
                                        style="max-width: 600px"    
                                        alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                                    <div>
                                        <span class="btn btn-raised btn-round btn-default btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="about_image" />
                                        </span>
                                        @if($data[0]->getFirstMedia('about_image'))
                                        <span href="#pablo" onclick="deleteBtn('{{route('imgdelete', ['imgid' => $data[0]->getFirstMedia('about_image')['id']])}}')" class="btn btn-danger btn-round fileinput-exists"
                                            data-dismiss="fileinput">
                                            <i class="fa fa-times"></i> Remove</span>
                                        @endif
                                    </div>
                                </div>

                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                            @endif
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endsection
    <!-- Initialize Quill editor -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    
 

    @push('js')
        <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    @endpush
