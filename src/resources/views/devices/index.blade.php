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

    <div class="d-sm-flex align-items-center justify-content-between mb-5">
        <span class="d-block text-nowrap">Address to Display:</span>
        <select name="" id="" class="form-select mt-2 mb-3 mt-sm-0 mb-sm-0 ms-sm-3 me-sm-3">
            <option value="">{{ $address }}</option>
        </select>
        <a href="{{ route('addresses.index') }}" class="text-nowrap">Manage Addresses</a>
    </div>

    <div class="border mb-5" style="border-radius: 0.25rem;">
        <ul class="list-group list-group-flush mt-1 mb-1">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3">
                        <strong class="d-inline-block mt-1">Address</strong>
                    </div>
                    <div class="col-md-9">
                        {{ $address }}
                        <button class="btn btn-link btn-sm" data-copy-text="{{ $address }}"><i class="far fa-copy"></i></button>
                    </div>
                </div>
            </li>

            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3">
                        <strong class="d-inline-block mt-1">OBD Balance</strong>
                    </div>
                    <div class="col-md-9">
                        <span class="me-1">{{ $balance }}&nbsp;OBD</span>
                        <a href="{{ route('wallet.index') }}" class="d-inline-block ms-3">Send / Receive</a>
                    </div>
                </div>
            </li>

            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3">
                        <strong class="d-inline-block mt-1">pNFTs</strong>
                    </div>
                    <div class="col-md-9 d-sm-flex justify-content-between align-items-center">
                        <div>
                        <span class="d-inline-block mt-1">{{ $devices_count }}</span>
                        <a href="{{ route('devices.create') }}" class="d-inline-block ms-3">Add Device</a>
                        </div>
                        <a href="#" class="d-inline-block mt-4 mt-sm-0">Check Blockchain for Updates</a>
                    </div>
                </div>
            </li>
        </ul>
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
