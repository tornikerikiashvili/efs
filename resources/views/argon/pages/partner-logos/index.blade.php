@extends('argon.layouts.app')

@section('content')
    @include('argon.layouts.headers.cards')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="mb-0" style="display: inline-block">Partner Logos</h3>
                        <div class="float-right">
                            <a href="{{ route('partner-logos.create') }}" class="btn btn-success mt-4">{{ __('Add') }}</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Order</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Link</th>
                                    <th scope="col">Logo</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($partners as $partner)
                                    <tr>
                                        <td>{{ $partner->sort_order }}</td>
                                        <th scope="row">
                                            <span class="name mb-0 text-sm">{{ $partner->name }}</span>
                                        </th>
                                        <td>
                                            @if ($partner->url)
                                                <a href="{{ $partner->url }}" target="_blank" rel="noopener">{{ \Illuminate\Support\Str::limit($partner->url, 40) }}</a>
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td>
                                            <img src="{{ $partner->getFirstMediaUrl('main') }}" alt="{{ e($partner->imageAltForLocale('ka')) }}" style="max-width:120px; max-height:50px">
                                        </td>
                                        <td>
                                            <span class="badge badge-dot mr-4">
                                                <i class="bg-{{ $partner->status ? 'success' : 'warning' }}"></i>
                                                <span class="status">{{ $partner->status ? 'SHOW' : 'HIDDEN' }}</span>
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('partner-logos.edit', ['partner_logo' => $partner->id]) }}" class="btn btn-sm btn-icon-only text-light" title="edit">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
