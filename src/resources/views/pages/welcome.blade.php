@extends('layouts.app')


@section('head')
    <title>OBADA Inventory Manager Demo</title>
    <meta name="description" content="OBADA Inventory Manager Demo">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
    <script src="{{ mix('/js/base.js') }}"></script>
@endsection


@section('content')
    @include('common.nav', ['fixed' => false])

    <div class="main">

        <div class="container-lg">
            <section class="mt-5">
                <h1 class="text-center">pNFT Wallet</h1>
                <h4 class="text-center">Demo Site and Reference Design.</h4>
                <h5 class="text-center mt-4"><a href="{{ route('login.index') }}">Login</a> or <a href="{{ route('register.index') }}">Register</a></h5>
            </section>
        </div>

    </div>

    @include('common.footer')
@endsection
