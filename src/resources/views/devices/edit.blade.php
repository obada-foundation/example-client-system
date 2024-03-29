@extends('layouts.app-with-nav',[
    'page_title' => $page->title,
    'breadcrumb_name' => $page->breadcrumb_name,
])


@section('head')
    <title>{{ $page->title }}</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
    <script src="{{ mix('/js/devices_edit.js') }}"></script>
@endsection


@section('extra_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Accounts</a></li>
    <li class="breadcrumb-item"><a href="{{ route('devices.index', $account->getAddress()) }}">{{ $account->getBreadCrumbsAddress() }}</a></li>
    @if($page->isEdit)
        <li class="breadcrumb-item"><a href="{{ route('devices.show', $usn) }}">{{ $usn }}</a></li>
    @endif
@endsection


@section('page_content')
    @if($page->isEdit)
        <edit-device :device_id="'{{ $usn }}'"
                     get-usn-url="{{ route('generate.usn.compute') }}"
                     load-device-url="{{ route('devices.load', $usn) }}"
                     store-device-url="{{ route('devices.save') }}"
                     store-document-url="{{ route('devices.documents.store') }}"
                     device-url="{{ route('devices.show', $usn) }}">
        </edit-device>
    @else
        <edit-device :device_id="0"
                     address="{{ $account->getAddress() }}"
                     get-usn-url="{{ route('generate.usn.compute') }}"
                     store-device-url="{{ route('devices.save') }}"
                     store-document-url="{{ route('devices.documents.store') }}">
        </edit-device>
    @endif
@endsection
