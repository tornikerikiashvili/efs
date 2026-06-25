@extends('argon.layouts.app')

@section('content')
    @include('argon.layouts.headers.cards')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="mb-0" style="display: inline-block">Team / Founders</h3>
                        <div class="float-right">
                            <a href="{{ route('team-members.create') }}" class="btn btn-success mt-4">{{ __('Add') }}</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Order</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($teamMembers as $member)
                                    <tr>
                                        <td>{{ $member->sort_order }}</td>
                                        <th scope="row">
                                            <span class="name mb-0 text-sm">{{ $member->name_ka }}</span>
                                        </th>
                                        <td>{{ $member->position_ka }}</td>
                                        <td>
                                            <img src="{{ $member->getFirstMediaUrl('main') }}" alt="{{ e($member->imageAltForLocale('ka')) }}" style="max-width:80px">
                                        </td>
                                        <td>
                                            <span class="badge badge-dot mr-4">
                                                <i class="bg-{{ $member->status ? 'success' : 'warning' }}"></i>
                                                <span class="status">{{ $member->status ? 'SHOW' : 'HIDDEN' }}</span>
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('team-members.edit', ['team_member' => $member->id]) }}" class="btn btn-sm btn-icon-only text-light" title="edit">
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
