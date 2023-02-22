@extends('layouts.app')


@section('head')
    <title>{{ config('view.site_name') }}</title>
    <meta name="description" content="__description__">
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
                <h1 class="text-center lh-1 mb-5">A Decentralized Registry <br> <small style="font-size: 0.6em;">for storing</small> <br> Digital Product Passports (DPPs)</h1>

                <h5 class="text-center mb-5"><em>"The ITAD Blockchain"</em></h5>

                <h4 class="mb-5 text-center">
                    This site is reference implementing of the standard "<a href="https://www.obadafoundation.org/standard/">Representing Physical Assets using Non-Fungible Tokens (NFTs)</a>", being developed by <a href="http://obadafoundation.org">the OBADA Foundation </a>in conjunction with <a href="https://www.iso.org/committee/6266604.html">ISO TC/307 "Blockchain and Digital Ledger Technologies"</a>.<br>
                    The reference implementation is a product of <a href="http://www.obada.io">the OBADA DAO</a>.<br>
                    The OBADA Foundation and the OBADA DAO were formed by a coalition in the IT Asset Disposition (ITAD) Sector.
                </h4>

                <h3 class="text-center pt-4 pb-4"><a href="{{ route('login.index') }}">Login</a> or <a href="{{ route('register.index') }}">Register</a></h3>

                <h2 class="mt-5 text-center">This website demonstrates three components</h2>
                <ul>
                    <li class="mb-2"><strong>The "Reference Design".</strong> <a href="https://github.com/obada-foundation/reference-design">View source code on Github.</a>
                        <ul>
                            <li>A local application consisting of this simple website plus a small local database. The reference design provides a simple front end to demonstrate how an inventory system connects to the "Client Helper".</li>
                        </ul>
                    </li>
                    <li class="mb-2"><strong>The Client Helper.</strong> <a href="https://github.com/obada-foundation/client-helper">View source code on Github.</a>
                        <ul>
                            <li>A middleware application to be installed locally as a "bolt on" to an inventory system. The Client Helper syncs to the front end using a simple Restful API, reformatting the inventory data into cryptographic format which synchs to the Decentralized Registry using a gRPC interface.</li>
                        </ul>
                    </li>
                    <li class="mb-2"><strong>The Decentralized Registry.</strong> <a href="https://github.com/obada-foundation/registry">View source code on Github</a> <small>(For Github access please contact <strong>techops@obada.io</strong>)</small>.
                        <ul>
                            <li>A local node of the Decentralized Registry (a W3C compliant DID registry using an enterprise DLT system, synchronizes and broadcasts all data changes with the other nodes in the decentralized network.</li>
                        </ul>
                    </li>
                </ul>
            </section>
        </div>

    </div>

    @include('common.footer')
@endsection
