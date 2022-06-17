@extends('layouts.app-sidenav',[
    'body_class'=>'landing-page',
    'page_title' => 'Edit Device'
])

@section('head')
    <title>Edit Device</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">

    <link rel="stylesheet" href="{{ mix('/css/app-vue.css') }}">
@endsection

@section('page_content')
    <edit-device :device_id="'{{ $usn }}'"
                 load-device-url="{{ route('devices.load', $usn) }}"
                 store-device-url="{{ route('devices.save') }}"
                 store-document-url="{{ route('devices.documents.store') }}">
    </edit-device>
@endsection


@section('scripts')
    <script src="{{ mix('/js/app-vue.js') }}"></script>
@endsection
