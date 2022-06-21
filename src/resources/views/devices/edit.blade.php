@extends('layouts.app-sidenav',[
    'body_class'=>'landing-page',
    'page_title' => $page->title
])


@section('head')
    <title>{{ $page->title }}</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">

    <link rel="stylesheet" href="{{ mix('/css/app-vue.css') }}">
@endsection


@section('scripts')
    <script src="{{ mix('/js/app-vue.js') }}"></script>
@endsection


@section('page_content')
    @if($page->isEdit)
        <edit-device :device_id="'{{ $usn }}'"
                     load-device-url="{{ route('devices.load', $usn) }}"
                     store-device-url="{{ route('devices.save') }}"
                     store-document-url="{{ route('devices.documents.store') }}">
        </edit-device>
    @else
        <edit-device :device_id="0"
                     store-device-url="{{ route('devices.save') }}"
                     store-document-url="{{ route('devices.documents.store') }}">
        </edit-device>
    @endif
@endsection
