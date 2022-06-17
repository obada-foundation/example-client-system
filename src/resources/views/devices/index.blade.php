@extends('layouts.app-sidenav',[
    'body_class'=>'landing-page',
    'page_title' => 'My pNFT Inventory'
])


@section('head')
    <title>Inventory List</title>
    <meta name="description" content="Obada Reference App Inventory List">
    <meta name="keywords" content="devices">

    <link rel="stylesheet" href="{{ mix('/css/app-vue.css') }}">
{{--    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"/>--}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css"/>
@endsection


@section('page_content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped" id="deviceList">
                <thead>
                <tr>
                    <th>USN</th>
                    <th>Manufacturer</th>
                    <th>Serial #</th>
                    <th>Part #</th>
                    <th>Checksum</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
{{--    <device-list devices-load-url="{{ route('devices.load-all') }}"></device-list>--}}
@endsection


@section('scripts')
    <script>
        window.devicesLoadUrl = '{{ route('devices.load-all') }}';
    </script>
    <!-- todo: move to js file as dependencies -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ mix('/js/app-vue.js') }}"></script>
    <script src="{{ mix('/js/device-list.js') }}"></script>
@endsection
