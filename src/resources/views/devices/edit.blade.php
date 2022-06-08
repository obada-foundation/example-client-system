@extends('layouts.app', ['body_class' => 'landing-page'])

@section('head')
    <title>Edit device</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"/>
@endsection

@section('content')
    @include('common.nav', ['fixed' => false])
    <div class="main">
        <div class="container">
            <h1 class="text-center">Edit device {{ $usn }}</h1>
            <section class="py-5 my-5">
                <edit-device :device_id="0" 
                    store-device-url="{{ route('devices.save') }}" 
                    store-document-url="{{ route('devices.documents.store') }}">
                </edit-device>
            </section>
        </div>

    </div>
    @include('common.footer')
@endsection

@section('scripts')
@endsection
