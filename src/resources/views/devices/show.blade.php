@extends('layouts.app-with-nav',[
    'page_title' => $page_title,
    'breadcrumb_name' => $usn,
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
    <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Accounts</a></li>
    <li class="breadcrumb-item"><a href="{{ route('devices.index', $device->address) }}">{{ $address_short }}</a></li>
@endsection


@section('title_action')
    @if ($hasNFT)
        <div class="flex-shrink-0">
            <a href="{{ route('nft.transfer.index', $device->usn) }}" class="btn btn-outline-primary"><i class="fas fa-exchange-alt"></i> Transfer pNFT</a>
            <div class="position-relative d-inline-block mb-5 mb-md-0">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#twoFaModal">Update to Blockchain</button>
                <small class="d-block lh-sm position-absolute top-100 w-100 text-center pt-1">Updates the blockchain.<br>A gas fee will be charged.</small>
            </div>
            <div class="position-relative d-inline-block mb-4 mb-md-0">
                <button class="btn btn-primary">Download Updates from Blockchain</button>
                <small class="d-block lh-sm position-absolute top-100 w-100 text-center pt-1">Warning: Will overwrite the local data.</small>
            </div>
        </div>
    @else
        <div>
            <span class="d-inline-block" data-bs-toggle="tooltip" title="Mint pNFT first">
                <button class="btn btn-outline-primary" disabled><i class="fas fa-exchange-alt"></i> Transfer pNFT</button>
            </span>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#twoFaModal">Mint pNFT</button>
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

    <h2 class="mb-1">Physical Asset Identifiers (PAIs)</h2>
    <p class="mb-2">Immutable identifiers are read from the physical asset and stored in an attached data object called &ldquo;physicalAssetIdentifiers&rdquo;.</p>
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
            </ul>
        </div>
    </div>


    <h2 class="mb-1">Decentralized Identifiers (DIDs)</h2>
    <p class="mb-2">The identifiers of the digital representation are algorithmically generated based on the PAIs.</p>
    <div class="card mb-5">
        <div class="card-body">
            <ul class="list-group list-group-flush mt-4 mb-2">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>DID</strong> (Decentralized Identifier)<br>
                            <small class="lh-sm d-inline-block text-black-50 mt-1">For system use</small>
                        </div>
                        <div class="col-md-8">
                            @isset($obit['did'])
                                <strong>{{ $obit['did'] }}</strong><button class="btn btn-link btn-sm" data-copy-text="{{ $obit['did'] }}"><i class="far fa-copy"></i></button>
                            @endisset
                            <br>
                            <small><em>Checksum and versioning digits have not been implemented yet.</em></small>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row align-items-md-center">
                        <div class="col-md-4">
                            <strong>USN</strong> (Universal Serial Number)<br>
                            <small class="lh-sm d-inline-block text-black-50 mt-1">Shortened version for human readability</small>
                        </div>
                        <div class="col-md-8">
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


    <h2 class="mb-1">Digital Representation Address</h2>
    <p class="mb-2">Information about where the digital representation is stored.</p>
    <div class="card mb-5">
        <div class="card-body">
            <ul class="list-group list-group-flush mt-2 mb-2">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Verifiable Data Registry</strong><br>
                            <small class="lh-sm d-inline-block text-black-50 mt-1">Name of the decentralized registry which stores the digital representation.</small>
                        </div>
                        <div class="col-md-8">
                            <a href="https://forum.obada.io/">OBADA DAO</a> ITAD Registry<br>
                            <small class="lh-sm d-inline-block text-black-50">Based on Cosmos SDK</small>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row align-items-md-center">
                        <div class="col-md-4">
                            <strong>DID URL</strong><br>
                            <small class="lh-sm d-inline-block text-black-50 mt-1">The full &ldquo;blockchain address&rdquo; for the digital representation.</small>
                        </div>
                        <div class="col-md-8">
                            @isset($obit['did'])
                                <strong>{{ $obit['did'] }}</strong><button class="btn btn-link btn-sm" data-copy-text="{{ $obit['did'] }}"><i class="far fa-copy"></i></button>
                            @endisset
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>


    <div class="d-flex justify-content-between mb-2">
        <h2 class="mb-0">Data Objects & Verified Credentials</h2>

            <a href="{{ route('devices.edit', $device->usn) }}#documents" class="btn btn-outline-primary">
                <i class="fas fa-edit"></i>&nbsp;Edit
            </a>
    </div>
    <div class="card mb-5">
        <div class="card-body">

            @if($device->documents->isEmpty())
                <ul class="list-group list-group-flush mt-2">
                    <li class="list-group-item">
                        <p class="mb-0 text-center">There are no data objects attached to this device</p>
                    </li>
                </ul>
            @else
                <div class="table-responsive p-2">
                    <table class="table table-striped" style="vertical-align: middle;">
                        <thead>
                            <tr>
                                <th>Data Object Types</th>
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
                                    <td>image {{-- {{ $document->type }} --}}</td>
                                    <td class="text-center">
                                        <input type="checkbox" {{ $document->encryption ? 'checked' : '' }} readonly disabled>
                                    </td>
                                    <td>{{ $document->name }}</td>
                                    <td><a href="{{ $document->path }}">{{ $document->path }}</a></td>
                                    <td><a href="#">Device Owner</a><br>[JWT token]</td>
                                    <td>-</td>
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
                        <div class="col-md-2">
                            <p><strong>Device Checksums</strong></p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Last Checked Date/Time</strong></p>
                        </div>
                        <div class="col-md-7">
                            <p><strong>Checksum</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <p><strong>Local: </strong></p>
                        </div>
                        <div class="col-md-3">
                            
                        </div>
                        <div class="col-md-7">
                            @isset($obit['checksum'])
                                <p>{{ $obit['checksum'] }}<button class="btn btn-link btn-sm" data-copy-text="{{ $obit['checksum'] }}"><i class="far fa-copy"></i></button></p>
                            @endisset
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <p><strong>Client-helper: </strong></p>
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-7">
                            @isset($obit['checksum'])
                                <p>{{ $obit['checksum'] }}<button class="btn btn-link btn-sm" data-copy-text="{{ $obit['checksum'] }}"><i class="far fa-copy"></i></button></p>
                            @endisset
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <p><strong>Blockchain: </strong></p>
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-7">
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


    <!--    <div class="d-flex justify-content-between mb-2">
            <h2 class="mb-0">Proof of Ownership</h2>
        </div>
        <div class="card mb-5">
            <div class="card-body">
                <em>Coming Soon.</em>
                <ul class="list-group list-group-flush mt-3 mb-2">
                    <li class="list-group-item">
                        View <a href="#">JSON Web Token</a> verification of identity signed by Tradeloop
                    </li>
                    <li class="list-group-item">
                        View <a href="#">JSON Web Token</a> verification of identity signed by Tradeloop
                    </li>
                </ul>
        </div>
    </div>-->


    <h2>Change History</h2>
    <div class="card mb-5">
        <div class="card-body">
{{--            <em>Coming Soon.</em>--}}
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
                            <td>-</td>
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
