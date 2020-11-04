@extends('layouts.app',['body_class'=>'landing-page'])

@section('head')
    <title>Device Details</title>
    <meta name="description" content="Device Details">
    <meta name="keywords" content="device details">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"/>

    <script>
        var _usn = '<?php echo $usn; ?>';
    </script>

@endsection

@section('content')
    @include('common.nav',['fixed'=>false])
    <div class="main">
        <div class="container">
            <h1 class="text-center">Device Details</h1>
            <p class="text-center bold">USN: {{$usn}}</p>
            <section class="py-5 my-5">
                <device-obit-detail :usn="_usn"></device-obit-detail>
            </section>
        </div>

    </div>
    @include('common.footer')
@endsection

@section('scripts')
@endsection
