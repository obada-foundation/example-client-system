@extends('layouts.app',['body_class'=>$body_class])

@section('content')
    @include('common.nav',['fixed'=>false])

    <div class="main">
        <div class="container">
            <h1>{{ $page_title }}</h1>

            <nav aria-label="Breadcrumb" class="breadcrumb mb-5">
                <a href="/" class="breadcrumb-item">Home</a>
                <span aria-current="page" class="breadcrumb-item active">{{ $page_title }}</span>
            </nav>

            <div class="row">
                <div class="col-xs-12 col-lg-3">
                    <div class="card mt-0 mb-5">
                        <div class="card-body">
                            <nav class="nav flex-column">
                                <ul class="navbar-nav">
                                    <li class="navbar-item">
                                        <a class="nav-link" href="{{ route('devices.index') }}">My Inventory (10)</a>
                                    </li>
                                    <li class="navbar-item">
                                        <span class="nav-link disabled">Export to CSV file</span>
                                    </li>
                                    <li class="navbar-item mt-3">
                                        <span class="nav-link disabled"><strong>Manage pNFT Inventory</strong></span>
                                        <ul class="">
                                            <li class="navbar-item"><a class="nav-link" href="{{ route('devices.create') }}">Create pNFT</a></li>
                                            <li class="navbar-item"><span class="nav-link disabled">Import from CSV file</span></li>
                                        </ul>

                                    </li>
                                    <li class="navbar-item mt-3">
                                        <span class="nav-link disabled"><strong>OBD Wallet</strong></span>
                                        <ul class="">
                                            <li class="navbar-item"><a class="nav-link" href="#">Wallet Balance (350 OBD)</a></li>
                                            <li class="navbar-item"><a class="nav-link" href="#">Transfer Funds</a></li>
                                        </ul>

                                    </li>
                                    <li class="navbar-item mt-3"><a class="nav-link" href="{{ route('documentation') }}">Documentation</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-9">
                    <main>
                        @yield('page_content')
                    </main>
                </div>
            </div>
        </div>
    </div>

    @include('common.footer')
@endsection
