@extends('layouts.app-with-nav',[
    'page_title' => 'My pNFT Wallet'
])


@section('head')
    <title>My pNFT Wallet</title>
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

    <div class="mb-5" style="margin-top: -2.25rem;">
        <span class="me-2">Address:</span>
        <select name="" id="" class="form-select d-inline-block" style="width: 300px; max-width: 100%;">
            <option value="">obid:45v4563g46357g54575g757</option>
        </select>
    </div>

    <div class="card mb-5">
        <div class="card-body">
            <ul class="list-group list-group-flush mt-3 mb-3">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <strong class="d-inline-block mt-1">My Address</strong>
                        </div>
                        <div class="col-md-9">
                            obid:45v4563g46357g54575g757
                            <button class="btn btn-link btn-sm" data-copy-text="dfgsdsgsdfgdfgdfg"><i class="far fa-copy"></i></button>
                            <button type="button" class="btn btn-outline-primary ms-1">Create New Address</button>
                            <button type="button" class="btn btn-outline-primary ms-1">Enter Existing Address</button>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <strong class="d-inline-block mt-1">My Balance</strong>
                        </div>
                        <div class="col-md-9">
                            <span class="me-1">900&nbsp;OBD</span>
                            (<a target="_blank" href="{{ config('faucet.url') }}">OBADA Faucet</a>)
                            <button type="button" class="btn btn-outline-dark ms-2">Send</button>
                            <button type="button" class="btn btn-outline-dark ms-1">Receive</button>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <strong class="d-inline-block mt-1">Number of pNFTs</strong>
                        </div>
                        <div class="col-md-9">
                            <span class="d-inline-block mt-1">25 (synced &mdash; 10)</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>


    <div id="addButtonContainer" class="text-start text-md-end h-md-0 mb-4 mb-md-0" style="display: none;">
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
