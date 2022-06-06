@extends('layouts.app',['body_class' => 'landing-page'])

@section('head')
    <title>OBIT Detail</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"/>

    <script>
        var _usn = '<?php echo $usn; ?>';
    </script>

@endsection

@section('content')
    @include('common.nav',['fixed' => false])
    <div class="main">
        <div class="container">
            <h1 class="text-center">Client Helper (Wallet) > Obit Detail</h1>
            <section class="py-5 my-5">
                <obit-detail 
                    :key="_usn" 
                    load-obit-url="{{ route('obits.load', $usn) }}" 
                    to-chain-obit-url="{{ route('obits.to-chain', $usn) }}">
                </obit-detail>
            </section>
        </div>

    </div>
    @include('common.footer')
@endsection

@section('scripts')
@endsection
