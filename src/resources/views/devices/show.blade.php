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
    <li class="breadcrumb-item"><a href="{{ route('devices.index', $device->address) }}">{{ $account->getBreadCrumbsAddress() }}</a></li>
@endsection


@section('title_action')
    @if ($hasNFT)
        <div class="flex-shrink-0">
            <a href="{{ route('nft.transfer.index', $device->usn) }}" class="btn btn-outline-primary"><i class="fas fa-exchange-alt"></i> Transfer pNFT</a>
            <div class="position-relative d-inline-block ms-1 mb-4 mb-md-0">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#twoFaModal">Update to Blockchain</button>
                <small class="d-block lh-sm position-absolute top-100 w-100 text-center pt-1">{{ config('view.gas_fee_text') }}</small>
            </div>
        </div>
    @else
        <div>
            <span class="d-inline-block" data-bs-toggle="tooltip" title="Mint pNFT first">
                <button class="btn btn-outline-primary" disabled><i class="fas fa-exchange-alt"></i> Transfer pNFT</button>
            </span>
            <div class="position-relative d-inline-block ms-1 mb-4 mb-md-0">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#twoFaModal" style="min-width: 125px;">Mint pNFT</button>
                <small class="d-block lh-sm position-absolute top-100 w-100 text-center pt-1">{{ config('view.gas_fee_text') }}</small>
            </div>
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

    <h2 class="mb-1">Physical Asset Identifiers (PAIs) <sup class="fst-italic fs-6 text-success" style="top: -1em;">[section 5.1]</sup></h2>

    <p class="mt-4 mb-1 fw-bold fs-5">Immutable identifiers</p>
    <p>Unique and unchanging identifiers, permanently embedded by the manufacturer as part of the product. They remain fixed and can be resolved by either visible means or via firmware at any point in the entire lifecycle of the product. These identifiers, along with information about the retrieval method and the software used to read them, are stored in a required data object called &ldquo;physicalAssetIdentifiers&rdquo;.</p>
    <div class="card mb-4">
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
                            <strong>Other</strong>
                        </div>
                        <div class="col-md-8">
                            <em class="text-black-50">(coming soon)</em>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <p class="mt-4 mb-1 fw-bold fs-5">Non-immutable Identifiers</p>
    <p>Additional product identifiers that can help identify the product which are non permanently embedded as part of the product. Non-immutable identifiers are stored in a data object to be defined in the standard.</p>
    <div class="card mb-5">
        <div class="card-body">
            <ul class="list-group list-group-flush mt-3 mb-3">
        <li class="list-group-item">
            <div class="row">
                <div class="col-md-4">
                    <strong>GTIN, UPC, SKU, etc</strong>
                </div>
                <div class="col-md-8">
                    <em class="text-black-50">(coming soon)</em>
                </div>
            </div>
        </li>
    </ul>
        </div>
    </div>


    <h2 class="mb-1">Decentralized Identifiers (DIDs) <sup class="fst-italic fs-6 text-success" style="top: -1em;">[section 5.2]</sup></h2>
    <p class="mb-2">The identifiers of the digital representation are algorithmically generated based on the PAIs.</p>
    <div class="card mb-5">
        <div class="card-body">
            <ul class="list-group list-group-flush mt-4 mb-2">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>DID</strong> (Decentralized Identifier) <sup class="fst-italic text-success">[section 5.2.3]</sup><br>
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
                            <strong>USN</strong> (Universal Serial Number) <sup class="fst-italic text-success">[section 5.3]</sup><br>
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


    <h2 class="mb-1">Digital Representation Address <sup class="fst-italic fs-6 text-success" style="top: -1em;">[section 7]</sup></h2>
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
        <h2 class="mb-0">Data Objects & Verified Credentials <sup class="fst-italic fs-6 text-success" style="top: -1em;">[section 6]</sup> <sup class="fst-italic fs-6 text-success" style="top: -1em;">[section 5.2.4]</sup></h2>

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
<!--                                <th>Data Object Types</th>
                                <th>Encrypted</th>-->
                                <th>Description</th>
                                <th style="width: 50%;">Link to File</th>
                                <th>Signed by</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($device->documents as $document)
                                <tr>
<!--                                    <td>{{ $document->type }}</td>
                                    <td class="text-center">
                                        <input type="checkbox" {{ $document->encryption ? 'checked' : '' }} readonly disabled>
                                    </td>-->
                                    <td>{{ $document->name }}</td>
                                    <td><a href="{{ $document->path }}" class="text-break">{{ $document->path }}</a></td>
                                    <td>Owner&nbsp;[JWT&nbsp;token]</td>
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


    <h2>Change History <sup class="fst-italic fs-6 text-success" style="top: -1em;">[section 6.3]</sup></h2>
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
<!--                            <td>-</td>
                            <td>
                                @isset($obit['checksum'])
                                    <a href="{{ route('devices.show', $device->usn) }}.{{ $obit['checksum'] }}">{{ $obit['checksum'] }}</a>
                                @endisset
                            </td>-->
                            <td colspan="2"><em class="text-black-50">(coming soon)</em></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <p class="mb-2"><a href="#" class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#nft_code" aria-expanded="false" aria-controls="calculations2">Show Raw Data</a></p>

    <div id="nft_code" class="collapse">
        <nft-code did="{{ isset($obit['did']) ? $obit['did'] : '' }}" minted="{{ $hasNFT }}"></nft-code>
    </div>

    <hr class="mt-5">

    <p><span class="fst-italic text-success">[section X]</span> &mdash;  See this section of <a href="https://github.com/obada-foundation/standard/blob/main/proposed-changes/index.md">the standard</a>.</p>
@endsection
