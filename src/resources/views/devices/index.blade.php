@extends('layouts.app-with-nav',[
    'page_title' => 'My Device Inventory'
])


@section('head')
    <title>My Device Inventory</title>
    <meta name="description" content="Obada Reference App Inventory List">
    <meta name="keywords" content="devices">

    <link rel="stylesheet" type="text/css" href="{{ mix('/css/devices_list.css') }}"/>
@endsection


@section('scripts')
    <script>
        window.devicesLoadUrl = '{{ route('devices.load-all') }}';
    </script>
    <script src="{{ mix('/js/devices_list.js') }}"></script>
@endsection


@section('page_content')

    <div class="text-start text-md-end h-md-0 mb-4 mb-md-0">
        <a href="{{ route('devices.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;Add Device</a>
    </div>

{{--    <div class="table-responsive">--}}
        <table class="table table-striped" id="deviceList">
            <thead>
            <tr>
                <th style="width: 20px;"></th>
                <th style="width: 70px;">USN</th>
                <th>Manufacturer</th>
                <th>Part&nbsp;#</th>
                <th>Serial&nbsp;#</th>
                <th>#&nbsp;of&nbsp;documents</th>
                <th style="width: 75px;">Created</th>
            </tr>
            </thead>
        </table>
{{--    </div>--}}

    <hr>

    <div class="mt-4">
        <ul class="list-unstyled mb-0 d-lg-flex justify-content-lg-between">
            <li><i class="fas fa-check text-success"></i> - Synchronized with blockchain</li>
            <li><i class="fas fa-sync text-danger"></i> - Blockchain version updated</li>
            <li><i class="fas fa-sync text-warning"></i> - Local version updated</li>
        </ul>
    </div>

@endsection


@section('page_bottom')
    @include('common.network-fees-modal')
@endsection
