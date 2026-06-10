@extends('argon.layouts.app')

@section('content')
    @include('argon.layouts.headers.cards')
    @trixassets
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-body">

                        <form  method="POST"
                            action="{{ isset($project) ? route('projects.update', ['project' => $project['id']]) : route('projects.store') }}"
                            autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            
                            <input type="hidden" name="_method" value="{{ isset($project) ? 'put' : 'post' }}" />

                            <h6 class="heading-small text-muted mb-4">{{ __('Edit Blade') }}</h6>



                            <x-forms.input type="text" name="name_ka" headline="Name KA" value="{{  $project['name_ka'] ?? old('name_ka') }}" />
                            <x-forms.input type="text" name="name_en" headline="Name EN" value="{{  $project['name_en'] ?? old('name_en') }}" />
                            <x-forms.input type="text" name="meta_title_ka" headline="Meta Title KA" value="{{  $project['meta_title_ka'] ?? old('meta_title_ka') }}" />
                            <x-forms.input type="text" name="meta_title_en" headline="Meta Title EN" value="{{  $project['meta_title_en'] ?? old('meta_title_en') }}" />
                            <x-forms.input type="text" name="meta_description_ka" headline="Meta Description KA" value="{{  $project['meta_description_ka'] ?? old('meta_description_ka') }}" />
                            <x-forms.input type="text" name="meta_description_en" headline="Meta Description EN" value="{{  $project['meta_description_en'] ?? old('meta_description_en') }}" />

                            

                            <div class="pl-lg-4">
                                <div class="fileinput fileinput-new text-center {{ $errors->has('image') ? ' has-danger' : '' }}" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail img-raised">
                                        @if ($errors->has('image'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                        @endif
                                        <img src="{{isset($mediaItems[0]) ? $mediaItems[0]->getUrl() : 'https://winaero.com/blog/wp-content/uploads/2019/09/Photos-app-icon-256-colorful.png'}}"
                                        style="max-width: 600px"    
                                        alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                                    <div>
                                        <span class="btn btn-raised btn-round btn-default btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image" />
                                        </span>
                                        @if(isset($project) && isset($mediaItems[0]))
                                        <span href="#pablo" onclick="deleteBtn('{{route('imgdelete', ['imgid' => $mediaItems[0]['id']])}}')" class="btn btn-danger btn-round fileinput-exists"
                                            data-dismiss="fileinput">
                                            <i class="fa fa-times"></i> Remove</span>
                                        @endif
                                    </div>
                                </div>

                                <br><br>

                                @if(isset($project))
                                    <div class="form-group">
                                        <label>Short Content KA</label>
                                        {!! $project->trix('content_ka') !!}
                                     </div>
                                     <div class="form-group">
                                        <label>Short Content EN</label>
                                        {!! $project->trix('content_en') !!}
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label>Short Content KA</label>
                                        @trix(\App\Models\Projects::class, 'content_ka')
                                    </div>
                                    <div class="form-group">
                                        <label>Short Content EN</label>
                                        @trix(\App\Models\Projects::class, 'content_en')
                                    </div>
                                @endif
                               
                               
                               

                                <br>
                                <h3>status</h3>
                                <div class="form-check form-check-radio">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="status" id="status1" value="1" {{(isset($project) && $project['status'] == 1) ? 'checked' : ''}}>
                                        Show
                                        <span class="circle">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="form-check form-check-radio">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="status" id="status2" value="0" {{isset($project) && $project['status'] == 0 ? 'checked' : ''}}>
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
    <!-- Initialize Quill editor -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    
 

    @push('js')
        <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    @endpush
