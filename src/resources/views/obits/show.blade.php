@extends('layouts.app')

@section('head')
    <title>OBIT Detail</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">

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
                    to-chain-obit-url="{{ route('obits.to-chain', $usn) }}"
                    blockchain-url="{{ route('obits.from-chain', $usn) }}">
                </obit-detail>
            </section>
        </div>

    </div>
    @include('common.footer')
@endsection

@section('scripts')
@endsection
