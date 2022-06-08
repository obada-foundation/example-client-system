@extends('layouts.app-sidenav',[
    'body_class'=>'landing-page',
    'page_title' => 'My Inventory'
])

@section('head')
    <title>Inventory List</title>
    <meta name="description" content="Obada Reference App Inventory List">
    <meta name="keywords" content="devices">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"/>
@endsection

@section('scripts')
@endsection

@section('page_content')
    <device-list devices-load-url="{{ route('devices.load-all') }}"></device-list>
@endsection

@section('scripts')
@endsection
