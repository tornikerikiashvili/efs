@extends('argon.layouts.app')

@section('content')
    @include('argon.layouts.headers.cards')
    
   <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0" style="display: inline-block">News table</h3>
              <div class="float-right">
                  <a href="{{route('services.create')}}" type="submit" class="btn btn-success mt-4">{{ __('Add') }}</a>
              </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">Service Name</th>
                    <th scope="col" class="sort" data-sort="budget">Service Picture</th>
                    <th scope="col" class="sort" data-sort="status">Status</th>
                    <th scope="col" class="sort" data-sort="completion">Created</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($services as $service)
                    <tr>
                      <th scope="row">
                        <div class="media align-items-center">
                          <div class="media-body">
                            <span class="name mb-0 text-sm">{{$service['name_ka']}}</span>
                          </div>
                        </div>
                      </th>
                      <td class="budget">
                        <img  src="{{ $service->getFirstMediaUrl('main') }}" style="max-width:120px">
                      </td>
                      <td>
                        <span class="badge badge-dot mr-4">
                          <i class="bg-{{($service['status'] == true) ? 'success' : 'warning'}}"></i>
                         
                          <span class="status">{{($service['status'] == true) ? 'SHOW' : 'HIDDEN'}}</span>
                        </span>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          {{$service['created_at'] }}
                        </div>
                      </td>
                      <td class="text-right">
                        <div class="dropdown">
                          <a href="{{ route('services.edit',['service' =>  $service['id']]) }}" class="btn btn-sm btn-icon-only text-light" title="edit" href="#" role="button">
                            <i class="fas fa-ellipsis-v"></i>
                          </a>
                          
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- Card footer -->

            {{-- pagination --}}
            {{-- <div class="card-footer py-4">
              <nav aria-label="...">
                <ul class="pagination justify-content-end mb-0">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">
                      <i class="fas fa-angle-left"></i>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                  <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">
                      <i class="fas fa-angle-right"></i>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div> --}}
          </div>
        </div>
      </div>
      

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush