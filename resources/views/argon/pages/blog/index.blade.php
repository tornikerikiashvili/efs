@extends('argon.layouts.app')

@section('content')
    @include('argon.layouts.headers.cards')
   <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header border-0">
              <h3 class="mb-0" style="display: inline-block">Blog table</h3>
              <div class="float-right">
                <a href="{{route('blog.create')}}" type="submit" class="btn btn-success mt-4">{{ __('Add') }}</a>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">Blog Name</th>
                    <th scope="col" class="sort" data-sort="budget">Blog Picture</th>
                    <th scope="col" class="sort" data-sort="status">Status</th>
                    <th scope="col" class="sort" data-sort="completion">Created</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($allblogs as $blog)
                    <tr>
                      <th scope="row">
                        <div class="media align-items-center">
                          <div class="media-body">
                            <span class="name mb-0 text-sm">{{$blog['name_ka']}}</span>
                          </div>
                        </div>
                      </th>
                      <td class="budget">
                        <img  src="{{ $blog->getFirstMediaUrl('main') }}" style="max-width:120px">
                      </td>
                      <td>
                        <span class="badge badge-dot mr-4">
                          <i class="bg-{{($blog['status'] == true) ? 'success' : 'warning'}}"></i>
                          <span class="status">{{($blog['status'] == true) ? 'SHOW' : 'HIDDEN'}}</span>
                        </span>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          {{$blog['created_at'] }}
                        </div>
                      </td>
                      <td class="text-right">
                        <div class="dropdown">
                          <a href="{{ route('blog.edit',['blog' =>  $blog['id']]) }}" class="btn btn-sm btn-icon-only text-light" title="edit" role="button">
                            <i class="fas fa-ellipsis-v"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
