@extends('layouts.app',['body_class'=>'landing-page'])


@section('head')
    <title>OBADA Inventory Manager Demo</title>
    <meta name="description" content="OBADA Inventory Manager Demo">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
@endsection


@section('content')
    @include('common.nav', ['fixed' => false])

    <div class="main">

        <div class="container-md">
            <section class="">
                <h1 class="text-center">pNFT Inventory Manager</h1>
                <h4 class="text-center">An <a href="https://www.obada.io/">OBADA</a> Blockchain Reference Design</h4>

                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <h2 class="text-center mt-5">About this Demo</h2>
                        <p class="text-center text-danger">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea eveniet impedit necessitatibus numquam, tempora veniam voluptatem. Facere inventore obcaecati quis quod ut! Commodi eius, eligendi inventore iste neque nihil sit?</p>

                        <h4 class="text-center"><a href="{{ route('login.index') }}">Login</a> or <a href="{{ route('register.index') }}">Register</a></h4>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <h2 class="text-center mt-5">Documentation</h2>
                        @include('common.documentation-list')
                    </div>
                </div>

            </section>
        </div>

    </div>

    @include('common.footer')
@endsection
