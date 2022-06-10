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

                    <div class="row">
                        <div class="col-xs-12 col-md-3">
                            <div class="card mt-0">
                                <div class="card-body">
                                    <nav class="nav flex-column">
                                        <a class="nav-link" href="/">Home</a>
                                        <a class="nav-link" href="/devices">My Inventory</a>
                                        <a class="nav-link" href="{{ route('devices.create') }}">Add New Part</a>
                                        <a class="nav-link" href="#">Help</a>
                                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
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
                    <h1 class="text-center">OBADA Prototype</h1>

                    <div class="row pt-5">
                        <div class="col-6">
                            <h2 class="text-center">Blockchain Tools</h2>
                            <p class="text-center">Tools to help integrate and debug OBADA.</p>
                            <ul class="bullet-list">
                                <li><b><a href="{{ route('generate.usn.index') }}">Obit Generator Tool</a></b> - demonstrates creation of an obit and a USN.</li>
                                <li><b><a href="{{ route('generate.checksum.index') }}">Obit Checksum Generator</a></b> - demonstrates how the obit checksum is generated.</li>
                            </ul>
                        </div>

                        <div class="col-6">
                            <h2 class="text-center">OBADA sites and tools</h2>
                            <ul class="bullet-list">
                                <li>
                                    <b><a href="https://www.obada.io" target="__blank">OBADA Foundation</a></b> - homepage of the OBADA governing body.
                                </li>
                                <li>
                                    <b><a href="https://github.com/obada-foundation" target="__blank">OBADA Github</a></b> - repository of OBADA Code.
                                </li>
                                <li>
                                    <b><a href="https://github.com/obada-foundation/php-client-library" target="__blank">API Documentation</a></b> - documentation for the OBADA API
                                </li>
                                <li>
                                    <b><a href="http://explorer.alpha.obada.io" target="__blank">Blockchain Explorer</a></b>
                                </li>
                            </ul>
                        </div>
                    </div>

                </section>
            </div>

        @endif

    </div>

    @include('common.footer')
@endsection
