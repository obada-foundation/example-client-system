@extends('layouts.app-sidenav',[
    'body_class'=>'landing-page',
    'page_title' => 'Device Details'
])

@section('head')
    <title>Device Details</title>
    <meta name="description" content="Device Details">
    <meta name="keywords" content="device details">

    <link rel="stylesheet" href="{{ mix('/css/app-vue.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"/>

    <script>
        var _device_id = '{{ $device->usn }}';
    </script>

@endsection

@section('page_content')

    <div class="card mb-5">
        <div class="card-body">
            <h2 class="d-flex justify-content-between">
                Device Identification
                <a href="/devices/{{ $device->usn }}/edit" class="btn btn-primary btn-rounded pull-right"><i class="fas fa-edit"></i> Edit</a>
            </h2>

            <ul class="device-information-list mt-4 mb-2">
                <li class="data-row">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Serial Number</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>{{ $device->serial_number }}</p>
                        </div>
                    </div>
                </li>

                <li class="data-row">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Manufacturer</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>{{ $device->manufacturer }}</p>
                        </div>
                    </div>
                </li>

                <li class="data-row">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Part Number</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>{{ $device->part_number }}</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>


    <div class="card mb-5">
        <div class="card-body">
            <h2>Device Data & Information</h2>

            <device-detail :device_id="_device_id"
                load-device-url="{{ route('devices.load', $device_id) }}"
                store-obit-url="{{ route('obits.store') }}">
            </device-detail>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="{{ mix('/js/app-vue.js') }}"></script>
@endsection
