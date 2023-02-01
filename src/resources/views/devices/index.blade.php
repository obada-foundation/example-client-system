@extends('layouts.app-with-nav',[
    'page_title'      => 'Account (lot) ' . $account->getShortAddress(),
    'breadcrumb_name' => $account->getBreadCrumbsAddress()
])


@section('head')
    <title>Account (lot) {{ $account->getShortAddress() }}</title>
    <meta name="description" content="Obada Reference App Inventory List">
    <meta name="keywords" content="devices">

    <link rel="stylesheet" type="text/css" href="{{ mix('/css/devices_list.css') }}"/>
@endsection


@section('scripts')
    <script>
        window.devicesLoadUrl = '{{ route('devices.load-all', ['address' => $account->getAddress()]) }}';
        window.pageUrl = '{{ route('devices.index', $account->getAddress()) }}';
        window.mintNftUrl = '{{ route('nft.mint', ['usn' => '@usn']) }}';
    </script>
    <script src="{{ mix('/js/devices_list.js') }}"></script>
@endsection


@section('extra_alerts')
    @if($transfer_success == 1)
        <div class="alert alert-success mt-4 mb-0">
            <small><i class="fas fa-info-circle me-1 fs-6"></i></small>
            pNFT successfully transferred
        </div>
    @endif
@endsection


@section('extra_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Accounts</a></li>
@endsection


@section('page_content')

    <div class="border mb-5" style="border-radius: 0.25rem;">
        <ul class="list-group list-group-flush mt-1 mb-1">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3">
                        <strong class="d-inline-block mt-1">Address (Lot Name)</strong>
                    </div>
                    <div class="col-md-9">
                        <div class="mt-1 mb-1">
                            {{ $account->getAddress() }}
                            <button class="btn btn-link btn-sm" data-copy-text="{{ $account->getAddress() }}"><i class="far fa-copy"></i></button>
                        </div>
                    </div>
                </div>
            </li>

            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3">
                        <strong class="d-inline-block mt-2">Account Name</strong>
                    </div>
                    <div class="col-md-9">
                        <rename-account name="{{ $account->getName() }}" save-name-url="{{ route('accounts.update-account', $account->getAddress()) }}"></rename-account>
                    </div>
                </div>
            </li>

            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3">
                        <strong class="d-inline-block mt-1">System Credits (OBD Balance)</strong>
                    </div>
                    <div class="col-md-9">
                        <span>{{ $account->getFormattedBalance() }}&nbsp;OBD</span>
                        <span class="ms-2 me-2 text-muted">|</span>
                        <a href="{{ route('wallet.index', $account->getAddress()) }}" class="d-inline-block">Send or Receive</a>
                        <span class="ms-2 me-2 text-muted">|</span>
                        <a target="_blank" href="{{ config('faucet.url') }}">Get a small amount for testing</a>
                    </div>
                </div>
            </li>

            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-3">
                        <strong class="d-inline-block mt-1 mb-1">Inventory</strong>
                    </div>
                    <div class="col-md-9 d-sm-flex justify-content-between align-items-center">
                        <div>
                            <span class="d-inline-block mt-1 mb-1">
                                {{ $total_nft_count }} items ({{ $account->getNftCount() }} minted, {{ $not_minted_count }} unminted)
                            </span>
                            <span class="ms-2 me-2 text-muted">|</span>
                            <a href="{{ route('devices.create', $account->getAddress()) }}" class="d-inline-block">Add Device</a>
                            <span class="ms-2 me-2 text-muted">|</span>
                            <a href="{{ route('devices.import.index', $account->getAddress()) }}" class="d-inline-block">Import CSV</a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div id="addButtonContainer" class="text-start text-md-end h-md-0 mb-4 mb-md-0">
        <span class="d-inline-block" data-bs-toggle="tooltip" title="coming soon">
            <button href="#" class="btn btn-secondary" disabled><small><i
                    class="fas fa-upload me-2"></i></small>Mint All</button></span>
    </div>

    <table class="table table-striped" id="deviceList">
        <thead>
        <tr>
            <th style="max-width: 60px;"></th>
            <th style="width: 70px;">USN</th>
            <th>Manufacturer</th>
            <th>Part&nbsp;#</th>
            <th>Serial&nbsp;#</th>
            <th>#&nbsp;of&nbsp;data&nbsp;objects</th>
            <th style="width: 75px;">Created</th>
        </tr>
        </thead>
    </table>

    <hr>

    <div class="mt-4">
        <ul class="list-unstyled mb-0 d-lg-flex justify-content-lg-between">
            <li><i class="fas fa-check text-success"></i> - Synchronized with blockchain</li>
            <li><i class="fas fa-sync text-danger"></i> - Blockchain newer</li>
            <li><i class="fas fa-sync text-warning"></i> - Local newer</li>
        </ul>
    </div>

@endsection
