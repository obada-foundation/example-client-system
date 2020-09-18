@extends('layouts.app',['body_class'=>'landing-page'])

@section('head')
    <title>OBIT Detail</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"/>

    <script>
        var _obit_id = '<?php echo $obit_id; ?>';
    </script>

@endsection

@section('content')
    @include('common.nav',['fixed'=>false])
    <div class="main">
        <div class="container">
            <h1 class="text-center">OBIT Detail</h1>
            <section class="py-5 my-5">
                <obit-detail :obit_id="_obit_id"></obit-detail>
            </section>
        </div>

    </div>
    @include('common.footer')
@endsection

@section('scripts')
@endsection
