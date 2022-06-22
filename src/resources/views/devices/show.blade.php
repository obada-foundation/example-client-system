@extends('layouts.app-sidenav',[
    'body_class'=>'landing-page',
    'page_title' => 'pNFT Details'
])


@section('head')
    <title>pNFT Details</title>
    <meta name="description" content="Device Details">
    <meta name="keywords" content="device details">
@endsection


@section('scripts')

    <script>
        window._device_id = '{{ $device->usn }}';
        window.storeObitUrl = '{{ route('obits.store') }}';
    </script>
    <script src="{{ mix('/js/devices_detail.js') }}"></script>
@endsection


@section('page_content')
    <p class="mb-4">
        <strong>Last synced:</strong> June 21, 2022 7:10 UTC
        <button class="btn btn-link btn-sm" title="Sync Now"><i class="fas fa-sync"></i></button>
    </p>

    <h2>
        Physical Asset Identifiers
    </h2>
    <div class="card mb-5">
        <div class="card-body">

            <ul class="device-information-list mt-4 mb-2">
                <li class="data-row">
                    <div class="row">
                        <div class="col-md-4">
                            <p>
                                <strong>USN (Universal Serial Number)</strong>
                                <br>
                                <a href="#" data-bs-toggle="collapse" data-bs-target="#calculations1" aria-expanded="false" aria-controls="calculations1">Show Calculations</a></p>
                        </div>
                        <div class="col-md-8">
                            <p><strong>{{ $device->usn }}</strong>
                                <button class="btn btn-link btn-sm" data-copy-text="{{ $device->usn }}"><i class="far fa-copy"></i></button></p>
                        </div>
                    </div>
                </li>
                <li class="data-row">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Obit DID</strong>
                                <br>
                                <a href="#" data-bs-toggle="collapse" data-bs-target="#calculations1" aria-expanded="false" aria-controls="calculations1">Show Calculations</a></p>
                        </div>
                        <div class="col-md-8">
                            @isset($obit['did'])
                                <p>{{ $obit['did'] }}
                                    <button class="btn btn-link btn-sm" data-copy-text="{{ $obit['did'] }}"><i class="far fa-copy"></i></button></p>
                            @endisset
                        </div>
                    </div>
                </li>
                <li class="data-row">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Checksum</strong></p>
                        </div>
                        <div class="col-md-8">
                            @isset($obit['checksum'])
                                <p>{{ $obit['checksum'] }}<button class="btn btn-link btn-sm" data-copy-text="{{ $obit['checksum'] }}"><i class="far fa-copy"></i></button></p>
{{--                                <p class="text-danger">Sync Error: local checksum does not match! <br> bbbbb9ff0afd632fd7f11bfa8bbac041827e663ff7048de0fcdecbab5a0c8bb5 </p>--}}
                            @endisset
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
            </ul>

            <div id="calculations1" class="collapse">
                @include('common.calculations-table', [
                    'serial_number_hash' => $obit['serial_number_hash'],
                    'did' => $obit['did'],
                    'usn_base58' => $obit['usn_base58'],
                    'usn' => $device->usn
                ])
            </div>
        </div>
    </div>

    <h2>Digital Asset Address</h2>
    <div class="card mb-5">
        <div class="card-body">

            <ul class="device-information-list mt-4 mb-2">
                <li class="data-row">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Blockchain Address</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>
                                @isset($obit['did'])
                                    <strong>{{ $obit['did'] }}</strong><a href="https://gateway.obada.io/obits/{{ $obit['did'] }}" class="ms-2"><i class="fas fa-external-link-alt"></i></a>
                                @endisset
                            </p>
                        </div>
                    </div>
                </li>
                <li class="data-row">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>DID Registry</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>Cosmos ITAD Registry</p>
                        </div>
                    </div>
                </li>

                <li class="data-row">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Private Key</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p><button class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Show</button></p>
                            <p id="collapseOne" class="collapse"><span class="d-inline-block pt-2 pb-2">dfHGFHFDGhfdghDFGSEREGVREertyvret<button class="btn btn-link btn-sm" data-copy-text="private key"><i class="far fa-copy"></i></button></span></p>
                        </div>
                    </div>
                </li>
                <li class="data-row">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Created</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>June 21, 2022 7:05 UTC</p>
                        </div>
                    </div>
                </li>
                <li class="data-row">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Synchronized</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p>June 21, 2022 7:10 UTC<button class="btn btn-link btn-sm" title="Sync Now"><i class="fas fa-sync"></i></button></p>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
    </div>


    <h2>Device Data & Information</h2>
    <div class="card mb-5">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h4>Documents</h4>
                <a href="/devices/{{ $device->usn }}/edit" class="btn btn-outline-primary"><i class="fas fa-edit"></i> Edit</a>
            </div>
            <ul class="list-group list-group-flush mt-2">
                @if($device->documents->isEmpty())
                    <li class="list-group-item">
                        <p class="text-center">There are no documents attached to this device</p>
                    </li>
                @else
                    @foreach($device->documents as $document)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-4">
                                    <p>{{ $document->name }}</p>
                                </div>
                                <div class="col-md-8">
                                    <p>{{ $document->path }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>

    <h2>Proofs</h2>
    <div class="card mb-5">
        <div class="card-body">
            <ul class="list-group list-group-flush mt-3 mb-2">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Proof of Ownership</strong>
                        </div>
                        <div class="col-md-8 d-flex justify-content-between">
                            @isset($obit['owner'])
                                {{ $obit['owner'] }} <button class="btn btn-sm btn-outline-primary"><i class="fas fa-exchange-alt"></i> Transfer</button>
                            @endisset
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Trust Anchor(s)</strong>
                        </div>
                        <div class="col-md-8">
                            Trust Anchor 1, Trust Anchor 2
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <h2>Change History</h2>
    <div class="card mb-5">
        <div class="card-body">
            <ul class="list-group list-group-flush mt-3 mb-2">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>June 21, 2022 7:50 UTC</strong>
                        </div>
                        <div class="col-md-8">
                            Checksum: <br>
                            @isset($obit['checksum'])
                                {{ $obit['checksum'] }}<button class="btn btn-link btn-sm" data-copy-text="{{ $obit['checksum'] }}"><i class="far fa-copy"></i></button>
                            @endisset
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection
