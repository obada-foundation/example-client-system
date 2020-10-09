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
            <section class="py-5 my-5">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center">OBADA Inventory Manager Demo</h1>
                    </div>
                </div>
                <div class="row pt-5">
                    <div class="col-12">

                        <h2 class="pt-5">
                            OBADA sites and tools
                        </h2>
                        <ul class="bullet-list">
                            <li>
                                OBADA Gateway Server & Tools - to assist with understanding and for test and debug purposes.
                                <ul class="bullet-list">
                                    <li><b><a href="https://gateway.obada.io">Blockchain Explorer<a/></b></li>
                                    <li><b><a href="/generate/usn">Obit Generator Tool</a></b> - demonstrates creation of an obit and a USN.</li>
                                    <li><b><a href="/generate/hashing">Hashing Tools</a></b> - demonstrates how the document and root hash are generated.</li>
                                </ul>
                            </li>
                            <li>
                                <b><a href="https://www.obada.io">OBADA Foundation</a></b> - homepage of the OBADA governing body.
                            </li>
                        </ul>

                        <h2>This site is a simple "inventory manager" to demonstrate</h2>
                        <ul class="bullet-list">
                            <li>
                                How an inventory system can generate and store assets as "obits".
                            </li>
                            <li>
                                How obits can be synched to the blockchain.
                            </li>
                            <li>
                                How to import new obits into the system.
                            </li>
                        </ul>

                        <h2 class="pt-5">This site is also a "reference design" to assist with implementation, showing how the following components are used:</h2>
                        <ul class="bullet-list">
                            <li>
                                <b>The "Inventory Manager"</b> - a simple relational database system storing  inventory items and their associated documents, for multiple inventory owners.
                            </li>
                            <li>
                                <b>Obit Generation</b> - demonstrates the formulas for generating an obit, the USN (Universal Serial Number), and all hashing elements.
                            </li>
                            <li>
                                <b>Local Obit Storage</b> - Stores all obits locally, with tools to keep them synched to the local inventory.
                            </li>
                            <li>
                                <b>OBADA Client Library</b> - connects the obit list to an OBADA Gateway Server, which synchs them to the blockchain.
                            </li>
                            <li>
                                The source code for this application is available on Github (link).
                            </li>
                        </ul>



                    </div>
                </div>

            </section>
        </div>

    </div>
    @include('common.footer')
@endsection
