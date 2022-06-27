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

    <div class="text-center text-lg-end h-lg-0 mb-4 mb-lg-0">
        <a href="{{ route('devices.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;Add Device</a>
        <a href="#" class="btn btn-primary disabled" aria-disabled="true"><i class="fas fa-file-export"></i>&nbsp;Export to CSV</a>
        <a href="#" class="btn btn-primary disabled" aria-disabled="true"><i class="fas fa-file-import"></i>&nbsp;Import from CSV</a>
    </div>

{{--    <div class="table-responsive">--}}
        <table class="table table-striped" id="deviceList">
            <thead>
            <tr>
                <th style="width: 20px;"></th>
                <th>USN</th>
                <th>Manufacturer</th>
                <th>Part&nbsp;#</th>
                <th>Serial&nbsp;#</th>
                <th>#&nbsp;of&nbsp;documents</th>
            </tr>
            </thead>
        </table>
{{--    </div>--}}

    <hr>

    <div class="mt-4">
        <ul class="list-unstyled mb-0 d-lg-flex justify-content-lg-between">
            <li><i class="fas fa-check text-success"></i> - Synchronized with blockchain</li>
            <li><i class="fas fa-sync text-danger"></i> - Blockchain version is newer</li>
            <li><i class="fas fa-sync text-warning"></i> - Local version is newer</li>
        </ul>
    </div>

@endsection


@section('page_bottom')
    @include('common.network-fees-modal')
@endsection
