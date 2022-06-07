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
        <div class="container">
            <section class="">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center">OBADA Prototype</h1>
                    </div>
                </div>
                <div class="row pt-5">
                    @if (Auth::check())
                        <div class="col-6">
                            <h3 class="text-center">Inventory Manager</h3>
                            <p class="text-center">An example application to demonstrate how to connect a local system to OBADA.</p>
                            <ul class="bullet-list">
                                <li><b><a href="/devices">Local Inventory List<a/></b>
                                </li>
                                <li><b><a href="/obits">Local Obit List<a/></b></li>
                                <li><b><a href="{{ route('devices.create') }}">Add New Device</a></b></li>
                                <li><b><a href="/generate/hashing">Import From Blockchain</a></b></li>
                            </ul>
                        </div>
                    @endif
                    <div class="col-6">
                        <h3 class="text-center">Blockchain Tools</h3>
                        <p class="text-center">Tools to help integrate and debug OBADA.</p>
                        <ul class="bullet-list">
                            <li><b><a href="{{ route('generate.usn.index') }}">Obit Generator Tool</a></b> - demonstrates creation of an obit and a USN.</li>
                            <li><b><a href="{{ route('generate.checksum.index') }}">Obit Checksum Generator</a></b> - demonstrates how the obit checksum is generated.</li>
                        </ul>
                    </div>

                    <div class="col-6">
                        <h2 class="">
                            OBADA sites and tools
                        </h2>
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
                                <b><a href="http://explorer.alpha.obada.io" target="__blank">Blockchain Explorer<a/></b>
                            </li>
                        </ul>
                    </div>
                </div>

            </section>
        </div>

    </div>
    @include('common.footer')
@endsection
