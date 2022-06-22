@extends('layouts.app-sidenav',[
    'body_class'=>'landing-page',
    'page_title' => 'My pNFT Inventory'
])


@section('head')
    <title>My pNFT Inventory</title>
    <meta name="description" content="Obada Reference App Inventory List">
    <meta name="keywords" content="devices">

    <!-- TODO: move to css file ? -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css"/>
@endsection


@section('scripts')
    <script>
        window.devicesLoadUrl = '{{ route('devices.load-all') }}';
    </script>
    <script src="{{ mix('/js/devices_list.js') }}"></script>
@endsection


@section('page_content')
{{--    <div class="card">--}}
{{--        <div class="card-body">--}}
{{--            <div class="table-responsive">--}}
                <table class="table table-striped" id="deviceList">
                    <thead>
                    <tr>
                        <th style="width: 30px;">Sync</th>
                        <th>USN</th>
                        <th>Manufacturer</th>
                        <th>Part&nbsp;#</th>
                        <th>Serial&nbsp;#</th>
                        <th>#&nbsp;of&nbsp;documents</th>
                    </tr>
                    </thead>
                </table>
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
