@extends('layouts.app-sidenav',[
    'body_class'=>'landing-page',
    'page_title' => 'Device Details — USN ' . $device->usn
])


@section('head')
    <title>Device Details — USN {{ $device->usn }}</title>
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
    <h2>Physical Asset</h2>
    <div class="card mb-5">
        <div class="card-body">

            <ul class="list-group list-group-flush mt-3 mb-3">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Manufacturer</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $device->manufacturer }}
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Part Number</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $device->part_number }}
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Serial Number</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $device->serial_number }}
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>USN</strong><br><small>Universal Serial Number</small>
                        </div>
                        <div class="col-md-8">
                            <strong>{{ $device->usn }}</strong>
                                <button class="btn btn-link btn-sm" data-copy-text="{{ $device->usn }}"><i class="far fa-copy"></i></button>
                        </div>
                    </div>
                </li>
            </ul>

            <p><a href="#" class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#calculations1" aria-expanded="false" aria-controls="calculations1">Show Calculations</a></p>

            <div id="calculations1" class="collapse">
                @include('common.calculations-table', [
                    'usn_data' => $usn_data
                ])
            </div>
        </div>
    </div>


    <h2>pNFT Address</h2>
    <div class="card mb-5">
        <div class="card-body">

            <ul class="list-group list-group-flush mt-4 mb-2">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Blockchain Address</strong><br><small>Obit DID</small>
                        </div>
                        <div class="col-md-8">
                            @isset($obit['did'])
                                <strong>{{ $obit['did'] }}</strong><a href="https://gateway.obada.io/obits/{{ $obit['did'] }}" class="ms-2"><i class="fas fa-external-link-alt"></i></a>
                            @endisset
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Blockchain Registry</strong><br><small>DID Registry</small>
                        </div>
                        <div class="col-md-8">
                            <a href="https://forum.obada.io/">OBADA DAO</a> ITAD Registry<br><small>Based on Cosmos SDK</small>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>pNFT Created</strong>
                        </div>
                        <div class="col-md-8">
                            June 21, 2022 7:05 UTC
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Synchronized</strong>
                        </div>
                        <div class="col-md-8">
                            June 21, 2022 7:10 UTC<button class="btn btn-link btn-sm" title="Sync Now"><i class="fas fa-sync"></i></button>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
    </div>


    <div class="d-flex justify-content-between mb-2">
        <h2 class="mb-0">Device Data & Information</h2>
        <a href="{{ route('devices.edit', $device->usn) }}#documents" class="btn btn-outline-primary"><i class="fas fa-edit"></i> Edit</a>
    </div>
    <div class="card mb-5">
        <div class="card-body">

            @if($device->documents->isEmpty())
                <ul class="list-group list-group-flush mt-2">
                    <li class="list-group-item">
                        <p class="mb-0 text-center">There are no documents attached to this device</p>
                    </li>
                </ul>
            @else
                <div class="table-responsive p-2">
                    <table class="table table-striped" style="vertical-align: middle;">
                        <thead>
                            <tr>
                                <th>Information Type</th>
                                <th>Description</th>
                                <th style="width: 50%;">URL</th>
                                <th>Signed by</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($device->documents as $document)
                                <tr>
                                    <td>Other {{-- {{ $document->type }} --}}</td>
                                    <td>{{ $document->name }}</td>
                                    <td><a href="{{ $document->path }}">{{ $document->path }}</a></td>
                                    <td>JSON Web Token</td>
                                    <td>06/21/22</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <hr>

            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>pNFT Checksum</strong></p>
                        </div>
                        <div class="col-md-8">
                            @isset($obit['checksum'])
                                <p>{{ $obit['checksum'] }}<button class="btn btn-link btn-sm" data-copy-text="{{ $obit['checksum'] }}"><i class="far fa-copy"></i></button></p>
                            @endisset
                        </div>
                    </div>
                </li>
            </ul>

            <p class="mb-2"><a href="javascript:void(0);" class="btn btn-link">Show Calculations</a></p>
        </div>
    </div>


    <div class="d-flex justify-content-between mb-2">
        <h2 class="mb-0">Proof of Ownership</h2>
        <a href="{{ route('devices.transfer', $device->usn) }}" class="btn btn-outline-primary"><i class="fas fa-exchange-alt"></i> Transfer pNFT</a>
    </div>
    <div class="card mb-5">
        <div class="card-body">
            <ul class="list-group list-group-flush mt-3 mb-2">
                <li class="list-group-item">
                    View <a href="#">JSON Web Token</a> verification of identity signed by [Trust Anchor 1]
                </li>
                <li class="list-group-item">
                    View <a href="#">JSON Web Token</a> verification of identity signed by [Trust Anchor 2]
                </li>
            </ul>
        </div>
    </div>


    <h2>pNFT Version History</h2>
    <div class="card mb-5">
        <div class="card-body">
            <div class="table-responsive p-2">
                <table class="table table-striped" style="vertical-align: middle;">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th style="width: 75%;">Checksum</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>June 21, 2022 7:50 UTC</td>
                            <td>
                                @isset($obit['checksum'])
                                    <a href="{{ route('devices.show', $device->usn) }}.{{ $obit['checksum'] }}">{{ $obit['checksum'] }}</a>
                                @endisset
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
