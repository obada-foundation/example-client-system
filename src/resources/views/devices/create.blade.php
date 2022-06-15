@extends('layouts.app-sidenav', [
    'body_class' => 'landing-page',
    'page_title' => 'Add New Part'
])


@section('head')
    <title>Add New Part</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">

    <link rel="stylesheet" href="{{ mix('/css/app-vue.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"/>
@endsection


@section('page_content')
    <edit-device :device_id="0"
                 store-device-url="{{ route('devices.save') }}"
                 store-document-url="{{ route('devices.documents.store') }}">
    </edit-device>
@endsection


@section('scripts')
    <script src="{{ mix('/js/app-vue.js') }}"></script>
@endsection
