@extends('layouts.app-sidenav',[
    'body_class'=>'landing-page',
    'page_title' => 'My pNFT Inventory'
])


@section('head')
    <title>Inventory List</title>
    <meta name="description" content="Obada Reference App Inventory List">
    <meta name="keywords" content="devices">

    <link rel="stylesheet" href="{{ mix('/css/app-vue.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"/>
@endsection


@section('page_content')
    <device-list devices-load-url="{{ route('devices.load-all') }}"></device-list>
@endsection


@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="{{ mix('/js/app-vue.js') }}"></script>
@endsection
