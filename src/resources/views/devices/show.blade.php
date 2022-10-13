@extends('layouts.app-with-nav',[
    'page_title' => $page_title,
    'has_title_action' => true
])


@section('head')
    <title>{{ $page_title }}</title>
    <meta name="description" content="Device Details">
    <meta name="keywords" content="device details">
@endsection


@section('scripts')
    <script>
        window.storeObitUrl = '{{ route('obits.store') }}';
    </script>
    <script src="{{ mix('/js/devices_show.js') }}"></script>
@endsection


@section('extra_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('devices.index') }}">Wallet</a></li>
@endsection


@section('title_action')
    @if ($hasNFT)
        <div>
            <a href="{{ route('nft.transfer.index', $device->usn) }}" class="btn btn-outline-primary"><i class="fas fa-exchange-alt"></i> Transfer pNFT</a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#networkFeesModal">Update pNFT metadata</button>
        </div>
    @else
        <div>
            <span class="d-inline-block" data-bs-toggle="tooltip" title="Mint pNFT first">
                <button class="btn btn-outline-primary" disabled><i class="fas fa-exchange-alt"></i> Transfer pNFT</button>
            </span>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#networkFeesModal" >Mint pNFT</button>
        </div>
    @endif
@endsection


@section('page_content')

    @if (!$hasNFT)
        <mint-device
            device-url="{{ route('devices.show', $device->usn) }}"
            mint-nft-url="{{ route('nft.mint', $device->usn) }}"
            usn="{{ $device->usn }}"></mint-device>
    @else
        <update-metadata
            device-url="{{ route('devices.show', $device->usn) }}"
            update-metadata-url="{{ route('nft.update-metadata', $device->usn) }}"
            usn="{{ $device->usn }}"></update-metadata>
    @endif

    <h2>Physical Asset</h2>
    <div class="card mb-5">
        <div class="card-body">

            <ul class="list-group list-group-flush mt-3 mb-3">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Manufacturer</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $device->manufacturer }}
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Part Number</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $device->part_number }}
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Serial Number</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $device->serial_number }}
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>USN</strong><br><small>Universal Serial Number</small>
                        </div>
                        <div class="col-md-9">
                            <strong class="text-success">{{ $formatted_usn }}</strong><button
                                class="btn btn-link btn-sm" data-copy-text="{{ $device->usn }}"><i class="far fa-copy"></i></button>
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
                        <div class="col-md-3">
                            <strong>Obit DID</strong><br><small>Blockchain Address</small>
                        </div>
                        <div class="col-md-9">
                            @isset($obit['did'])
                                <strong>{{ $obit['did'] }}</strong><button class="btn btn-link btn-sm" data-copy-text="{{ $obit['did'] }}"><i class="far fa-copy"></i></button>
                            @endisset
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>DID Registry</strong><br><small>Blockchain Registry</small>
                        </div>
                        <div class="col-md-9">
                            <a href="https://forum.obada.io/">OBADA DAO</a> ITAD Registry<br><small>Based on Cosmos SDK</small>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>pNFT Created</strong>
                        </div>
                        <div class="col-md-9">
                            June 21, 2022 7:05 UTC
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Synchronized</strong>
                        </div>
                        <div class="col-md-9">
                            June 21, 2022 7:10 UTC
                            <i class="fas fa-sync text-warning ms-1" data-bs-toggle="tooltip" title="Local version updated"></i>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
    </div>


    <div class="d-flex justify-content-between mb-2">
        <h2 class="mb-0">Device Data & Information</h2>
            <a href="{{ route('devices.edit', $device->usn) }}#documents" class="btn btn-outline-primary">
                @if($device->documents->isEmpty())
                    <i class="fas fa-plus"></i>&nbsp;Add Device
                @else
                    <i class="fas fa-edit"></i>&nbsp;Edit
                @endif
            </a>
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
                                <th>Encrypted</th>
                                <th>Description</th>
                                <th style="width: 50%;">Link to File</th>
                                <th>Signed by</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($device->documents as $document)
                                <tr>
                                    <td>Other {{-- {{ $document->type }} --}}</td>
                                    <td class="text-center">
                                        <input type="checkbox" checked readonly disabled>{{-- {{ $document->is_encrypted }} --}}
                                    </td>
                                    <td>{{ $document->name }}</td>
                                    <td><a href="{{ $document->path }}">{{ $document->path }}</a></td>
                                    <td><a href="#">Device Owner</a><br>[JWT token]</td>
                                    <td><span style="white-space: nowrap">June 21, 2022</span></td>
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
                        <div class="col-md-3">
                            <p><strong>pNFT Checksum</strong></p>
                        </div>
                        <div class="col-md-9">
                            @isset($obit['checksum'])
                                <p>{{ $obit['checksum'] }}<button class="btn btn-link btn-sm" data-copy-text="{{ $obit['checksum'] }}"><i class="far fa-copy"></i></button></p>
                            @endisset
                        </div>
                    </div>
                </li>
            </ul>

            <!-- TODO: add checksum compute log -->
            <p class="mt-2 mb-2"><a href="#" class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#calculations2" aria-expanded="false" aria-controls="calculations2">Show Calculations</a></p>

            <div id="calculations2" class="collapse">
                Checksum calculation log<br>

                <code v-pre>{!! $compute_log !!}</code>
            </div>
        </div>
    </div>


    <div class="d-flex justify-content-between mb-2">
        <h2 class="mb-0">Proof of Ownership</h2>
    </div>
    <div class="card mb-5">
        <div class="card-body">
            <em>Coming Soon.</em>
<!--            <ul class="list-group list-group-flush mt-3 mb-2">
                <li class="list-group-item">
                    View <a href="#">JSON Web Token</a> verification of identity signed by Tradeloop
                </li>
                <li class="list-group-item">
                    View <a href="#">JSON Web Token</a> verification of identity signed by Tradeloop
                </li>
            </ul>-->
        </div>
    </div>


    <h2>pNFT Version History</h2>
    <div class="card mb-5">
        <div class="card-body">
            <em>Coming Soon.</em>
<!--            <div class="table-responsive p-2">
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
            </div>-->
        </div>
    </div>
@endsection
