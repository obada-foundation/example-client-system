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

        @if (Auth::check())
            <!-- move to separate /dashboard url ? -->
            <div class="container">
                <section>
                    <h1>Dashboard</h1>

                    <nav aria-label="Breadcrumb" class="breadcrumb mb-5">
                        <a href="/" class="breadcrumb-item">Home</a>
                        <a href="/account/contact-info.html" class="breadcrumb-item">Account</a>
                        <span aria-current="page" class="breadcrumb-item active">User Information</span>
                    </nav>

                    <div class="row">
                        <div class="col-xs-12 col-md-3">
                            <div class="card mt-0">
                                <div class="card-body">
                                    <nav class="nav flex-column">
                                        <ul class="navbar-nav">
                                            <li class="navbar-item"><a class="nav-link" href="/">Home</a></li>
                                            <li class="navbar-item">
                                                <a class="nav-link" href="/devices">My pNFT Inventory (10)</a>
                                                <ul class="navbar-nav pl-3">
                                                    <li class="navbar-item"><a class="nav-link" href="/devices">On Blockchain (7)</a></li>
                                                    <li class="navbar-item"><a class="nav-link" href="/devices">Stored Locally (3)</a></li>
                                                    <li class="navbar-item"><a class="nav-link" href="#">Sync to Blockchain</a></li>
                                                    <li class="navbar-item"><a class="nav-link" href="#">Export to CSV file</a></li>
                                                </ul>
                                            </li>
                                            <li class="navbar-item">
                                                <span class="nav-link">Manage pNFT Inventory</span>
                                                <ul class="navbar-nav pl-3">
                                                    <li class="navbar-item"><a class="nav-link" href="{{ route('devices.create') }}">Add Item Online</a></li>
                                                    <li class="navbar-item"><a class="nav-link" href="#">Import from CSV file</a></li>
                                                </ul>

                                            </li>
                                            <li class="navbar-item">
                                                <span class="nav-link">OBD Wallet</span>
                                                <ul class="navbar-nav pl-3">
                                                    <li class="navbar-item"><a class="nav-link" href="#">Wallet Balance (350 OBD)</a></li>
                                                    <li class="navbar-item"><a class="nav-link" href="#">Transfer Funds</a></li>
                                                </ul>

                                            </li>
                                            <li class="navbar-item"><a class="nav-link" href="#">Documentation</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-9">
                            <main>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor ducimus eos facilis labore maiores neque officia quisquam rem? Assumenda expedita explicabo fugit illum iusto non officiis quasi rerum sunt tempore.</p>
                            </main>
                        </div>
                    </div>
                </section>
            </div>

        @else

            <div class="container">
                <section class="">
                    <h1 class="text-center">pNFT Inventory Manager</h1>
                    <h4 class="text-center">An <a href="https://www.obada.io/">OBADA</a> Blockchain Reference Design</h4>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <h2 class="text-center mt-5">About this Demo</h2>
                            <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea eveniet impedit necessitatibus numquam, tempora veniam voluptatem. Facere inventore obcaecati quis quod ut! Commodi eius, eligendi inventore iste neque nihil sit?</p>

                            <h2 class="text-center mt-5">Documentation</h2>
                            <ul>
                                <li>
                                    <b><a href="https://www.obada.io" target="__blank">OBADA Foundation</a></b> - homepage of the OBADA governing body.
                                </li>
                                <li>
                                    <b><a href="https://github.com/obada-foundation" target="__blank">OBADA Github</a></b> - repository of OBADA Code.
                                </li>
                                <li>
                                    <b><a href="https://github.com/obada-foundation/client-api-library-php" target="__blank">API Documentation</a></b> - documentation for the OBADA API.
                                </li>
                                <li>
                                    <b><a href="http://explorer.alpha.obada.io" target="__blank">Blockchain Explorer</a></b>
                                </li>
                            </ul>
                        </div>

                        <div class="col-xs-12 col-sm-6">
                            <h2 class="text-center mt-5">Try it Out</h2>
                            <h4 class="text-center"><a href="{{ route('login.index') }}">Login</a> or <a href="{{ route('register.index') }}">Register</a></h4>
                        </div>
                    </div>

                </section>
            </div>

        @endif

    </div>

    @include('common.footer')
@endsection
