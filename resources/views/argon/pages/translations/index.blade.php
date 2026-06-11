@extends('argon.layouts.app')

@section('content')
    @include('argon.layouts.headers.cards')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="mb-0">Translations</h3>
                        <p class="text-muted mb-0 mt-2">Edit site text for Georgian and English. Changes are saved to <code>resources/lang</code>.</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Group</th>
                                    <th scope="col">Keys</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groups as $item)
                                    <tr>
                                        <th scope="row">
                                            <span class="name mb-0 text-sm">{{ $item['label'] }}</span>
                                            <div class="text-muted small">{{ $item['group'] }}.php</div>
                                        </th>
                                        <td>{{ $item['keys'] }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('translations.edit', $item['group']) }}" class="btn btn-sm btn-primary">Edit</a>
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
