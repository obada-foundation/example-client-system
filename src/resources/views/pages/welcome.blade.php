@extends('layouts.app',['body_class'=>'landing-page'])

@section('head')
    <title>OBADA Inventory Manager Demo</title>
    <meta name="description" content="OBADA Inventory Manager Demo">
    <meta name="keywords" content="__keywords__">

@endsection

@section('scripts')

@endsection

@section('content')
    @include('common.nav',['fixed'=>false])
    <div class="main">
        <div class="container">
            <section class="">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center">OBADA Prototype Changed</h1>
                    </div>
                </div>
                <div class="row pt-5">

                    <div class="col-6">
                        <h3 class="text-center">Inventory Manager</h3>
                        <p class="text-center">An example application to demonstrate how to connect a local system to OBADA.</p>
                        <ul class="bullet-list">
                            <li><b><a href="/devices">Local Inventory List<a/></b>
                            </li>
                            <li><b><a href="/obits">Local Obit List<a/></b></li>
                            <li><b><a href="/devices/0/edit">Add New Device</a></b></li>
                            <li><b><a href="/generate/hashing">Import From Blockchain</a></b></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <h3 class="text-center">Blockchain Tools</h3>
                        <p class="text-center">Tools to help integrate and debug OBADA.</p>
                        <ul class="bullet-list">
                            <li><b><a href="https://gateway.obada.io">Blockchain Explorer<a/></b></li>
                            <li><b><a href="/generate/usn">Obit Generator Tool</a></b> - demonstrates creation of an obit and a USN.</li>
                            <li><b><a href="/generate/hashing">Hashing Tools</a></b> - demonstrates how the document and root hash are generated.</li>
                        </ul>
                    </div>


                    <div class="col-12">

                        <h2 class="">
                            OBADA sites and tools
                        </h2>
                        <ul class="bullet-list">
                            <li>
                                <b><a href="https://www.obada.io">OBADA Foundation</a></b> - homepage of the OBADA governing body.
                            </li>
                            <li>
                                <b><a href="https://github.com/obada-protocol">OBADA Github</a></b> - repository of OBADA Code.
                            </li>
                            <li>
                                <b><a href="https://github.com/obada-protocol/php-client-library">API Documentation</a></b> - documentation for the OBADA API
                            </li>
                        </ul>


                    </div>
                </div>

            </section>
        </div>

    </div>
    @include('common.footer')
@endsection
