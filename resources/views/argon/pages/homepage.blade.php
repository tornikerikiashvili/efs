@extends('argon.layouts.app')

@section('content')
    @include('argon.layouts.headers.cards')

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-0">Homepage Slider</h3>

                        @foreach ($sliders as $slider)
                            <div class="row">
                                <div class="col-md-6 border">
                                    <i class="ni ni-laptop"></i>
                                    <img src="{{ $slider->getFirstMediaUrl('mainslider_ka') }}" class="img-fluid" >
                                </div>
                                <div class="col-md-6 border">
                                    <i class="ni ni-laptop"></i>
                                    <img src="{{ $slider->getFirstMediaUrl('mainslider_en') }}" class="img-fluid" >
                                </div>
                                <div class="col-md-6 border">
                                    <i class="ni ni-mobile-button"></i>
                                    <img src="{{ $slider->getFirstMediaUrl('mainmobileslider_ka') ??  $slider->getFirstMediaUrl('mainslider_ka')}}" class="img-fluid" >
                                </div>
                                <div class="col-md-6 border">
                                    <i class="ni ni-mobile-button"></i>
                                    <img src="{{ $slider->getFirstMediaUrl('mainmobileslider_en') ??  $slider->getFirstMediaUrl('mainslider_en')}}" class="img-fluid" >
                                </div>
                                <div class="col-md-12">
                                    <div class="row sliderparams" onchange="slideronchange({{ $slider['id'] }})">
                                        <div class="col-md-4">
                                            <label>Status:</label>
                                            <div class="custom-control custom-radio mb-3">
                                                <input type="radio" id="showing{{ $slider['id'] }}"
                                                    {{ $slider['status'] == 1 ? 'checked' : '' }}
                                                    name="status-{{ $slider['id'] }}" value="1"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="showing{{ $slider['id'] }}">Show</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="hiding{{ $slider['id'] }}"
                                                    {{ $slider['status'] == 0 ? 'checked' : '' }}
                                                    name="status-{{ $slider['id'] }}" value="0"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="hiding{{ $slider['id'] }}">Hide</label>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label>Sorting</label>
                                            <input type="number" value="{{ $slider['sort'] }}"
                                                name="sorting-{{ $slider['id'] }}"
                                                class="form-control form-control-alternative" style="max-width: 50px">
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                          <br><br>
                                            <span href="#pablo" onclick="deleteBtn('{{route('deleteslider', ['id' => $slider['id']])}}')" class="btn btn-danger btn-round fileinput-exists"
                                              data-dismiss="fileinput">
                                              <i class="fa fa-times"></i> Remove Slider</span>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <hr>
                            <br>
                        @endforeach

                    </div>

                    <hr>

                    <div class="card-header border-0">
                        <h3 class="mb-0">Add New Slider</h3>
                    </div>
                    <form method="POST" action="{{ route('storeslider') }}" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="_method" value="post" />

                        <div>
                            <div class="fileinput fileinput-new text-center {{ $errors->has('image') ? ' has-danger' : '' }}"
                                data-provides="fileinput">
                                <div class="row">
                                  
                                    <div class="col-md-8">
                                        <div>
                                            <span class="btn btn-raised btn-round btn-default btn-file"
                                                >
                                                <span class="fileinput-new">Select image For Georgian</span>
                                                <input type="file" name="mainsliderimage_ka" />
                                            </span><span>Required</span>
                                        </div>
                                        <div>
                                          <span class="btn btn-raised btn-round btn-default btn-file"
                                              >
                                              <span class="fileinput-new">Select image For English</span>
                                              <input type="file" name="mainsliderimage_en" />
                                          </span><span>Required</span>
                                      </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div>
                                            <span class="btn btn-raised btn-round btn-default btn-file"
                                                >
                                                <span class="fileinput-new">Select Mobile image For Georgian</span>
                                                <input type="file" name="mainmobilesliderimage_ka" />
                                            </span>
                                        </div>
                                        <div>
                                          <span class="btn btn-raised btn-round btn-default btn-file"
                                              >
                                              <span class="fileinput-new">Select Mobile image For English</span>
                                              <input type="file" name="mainmobilesliderimage_en" />
                                          </span>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3>status</h3>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="status"
                                                            id="status1" value="1"
                                                            {{ isset($news) && $news['status'] == 1 ? 'checked' : '' }}>
                                                        Show
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="status"
                                                            id="status2" value="0"
                                                            {{ isset($news) && $news['status'] == 0 ? 'checked' : '' }}>
                                                        Hide
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Sorting</label>
                                                    <input type="number" value="sorting" name="sorting"
                                                        class="form-control form-control-alternative"
                                                        style="max-width: 50px;display:inline-block">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                          <button type="submit" class="btn btn-success mt-4">{{ __('Add') }}</button>
                        </div>
                    </form>
                    <br>
                    <div class="card-header border-0">
                        <h3 class="mb-0">Customer Company Icons</h3>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">

                    </div>
                    <!-- Card footer -->
                </div>
            </div>
        </div>

        <script>
            function slideronchange(sliderId) {

                var statusinput = $("[name='status-" + sliderId + "']:checked").val();
                var sortinput = $("[name='sorting-" + sliderId + "']").val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('updatesliders') }}',
                    data: {
                        sliderId: sliderId,
                        status: statusinput,
                        sort: sortinput
                    },
                    type: 'POST',
                    success: function(result) {
                        if (result.status) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Updated',
                                showConfirmButton: false,
                                timer: 1000
                            })

                        } else {
                            Swal.fire('Something went wrong!', result.message, 'info')
                        }
                    }
                });

                console.log(sortinput);
            }



            function updateSlidersService(id) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('updatesliders') }}',
                    data: {
                        test: 'ssss'
                    },
                    type: 'POST',
                    success: function(result) {
                        if (result.status) {
                            Swal.fire('Deleted!', '', 'success').then((ttt) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Something went wrong!', '', 'info')
                        }
                    }
                });
            }
        </script>
    @endsection

    @push('js')
        <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    @endpush
