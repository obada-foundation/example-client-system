@extends('layouts.app-sidenav',[
    'body_class'=>'landing-page',
    'page_title' => 'Device Details'
])


@section('head')
    <title>Device Details</title>
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

    <h2 class="d-flex justify-content-between">
        Device Identification
        <a href="/devices/{{ $device->usn }}/edit" class="btn btn-primary btn-rounded"><i class="fas fa-edit"></i> Edit</a>
    </h2>
    <div class="card mb-5">
        <div class="card-body">

            <ul class="device-information-list mt-4 mb-2">
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
                            <p><strong>Private Key</strong></p>
                        </div>
                        <div class="col-md-8">
                            <p><button class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Show</button></p>
                            <p id="collapseOne" class="collapse" aria-labelledby="headingOne"><span class="d-inline-block pt-2 pb-2">dfHGFHFDGhfdghDFGSEREGVREertyvret</span></p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>


    <h2>Device Data & Information</h2>
    <div class="card mb-5">
        <div class="card-body">
            <h4>Documents</h4>
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

            <hr>

            <div class="d-flex justify-content-between">
                @if($device->obit_checksum)
                    <h4 class="text-success">Obit Exists</h4>
                    <div>
                        <a href="{{ route('obits.show', $device->usn) }}" class="btn btn-outline-primary">View Obit</a>
                        <button id="create_obit_btn" class="btn btn-primary">Update Obit</button>
                    </div>
                @else
                    <h4 class="text-danger">Obit Does Not Exist</h4>
                    <button id="create_obit_btn" class="btn btn-primary">Create Obit</button>
                @endif
            </div>

<!--            <device-detail :device_id="_device_id"
                load-device-url="{{ route('devices.load', $device->usn) }}"
                store-obit-url="">
            </device-detail>-->
        </div>
    </div>
@endsection
