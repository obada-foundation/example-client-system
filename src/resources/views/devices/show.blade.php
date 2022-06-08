@extends('layouts.app-sidenav',[
    'body_class'=>'landing-page',
    'page_title' => 'Device Details'
])

@section('head')
    <title>Device Details</title>
    <meta name="description" content="Device Details">
    <meta name="keywords" content="device details">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"/>

    <script>
        var _device_id = '<?php echo $device_id; ?>';
    </script>

@endsection

@section('page_content')
    <device-detail :device_id="_device_id"
        load-device-url="{{ route('devices.load', $device_id) }}"
        store-obit-url="{{ route('obits.store') }}">
    </device-detail>
@endsection

@section('scripts')
@endsection
