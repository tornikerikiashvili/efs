@props(['id' => 'locale-tabs'])

@php
    $activeTab = 'ka';
    foreach ($errors->getMessages() as $field => $messages) {
        if (str_ends_with($field, '_en')) {
            $activeTab = 'en';
            break;
        }
    }
@endphp

@once
<style>
    .locale-tabs .nav-tabs {
        border-bottom: 1px solid #dee2e6;
    }

    .locale-tabs .nav-tabs .nav-link {
        color: #525f7f;
        border: none;
        background-color: transparent;
    }

    .locale-tabs .nav-tabs .nav-link:hover,
    .locale-tabs .nav-tabs .nav-link:focus {
        color: #525f7f;
        background-color: rgba(0, 0, 0, 0.04);
        border: none;
    }

    .locale-tabs .nav-tabs .nav-link.active {
        color: #fff;
        background-color: #7268e5;
        border: none;
    }
</style>
@endonce

<div class="locale-tabs mb-4">
    <ul class="nav nav-tabs nav-fill" id="{{ $id }}-nav" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'ka' ? 'active' : '' }}"
                id="{{ $id }}-ka-tab"
                data-toggle="tab"
                href="#{{ $id }}-ka"
                role="tab"
                aria-controls="{{ $id }}-ka"
                aria-selected="{{ $activeTab === 'ka' ? 'true' : 'false' }}">
                Georgian
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'en' ? 'active' : '' }}"
                id="{{ $id }}-en-tab"
                data-toggle="tab"
                href="#{{ $id }}-en"
                role="tab"
                aria-controls="{{ $id }}-en"
                aria-selected="{{ $activeTab === 'en' ? 'true' : 'false' }}">
                English
            </a>
        </li>
    </ul>
    <div class="tab-content border border-top-0 rounded-bottom p-4 bg-white" id="{{ $id }}-content">
        <div class="tab-pane fade {{ $activeTab === 'ka' ? 'show active' : '' }}"
            id="{{ $id }}-ka"
            role="tabpanel"
            aria-labelledby="{{ $id }}-ka-tab">
            {{ $ka }}
        </div>
        <div class="tab-pane fade {{ $activeTab === 'en' ? 'show active' : '' }}"
            id="{{ $id }}-en"
            role="tabpanel"
            aria-labelledby="{{ $id }}-en-tab">
            {{ $en }}
        </div>
    </div>
</div>
