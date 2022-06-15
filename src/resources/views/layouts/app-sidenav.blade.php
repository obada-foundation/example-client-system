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
                <div class="col-xs-12 col-md-3">
                    <div class="card mt-0">
                        <div class="card-body">
                            <nav class="nav flex-column">
                                <ul class="navbar-nav">
                                    <li class="navbar-item"><a class="nav-link" href="/">Home</a></li>
                                    <li class="navbar-item mt-3">
                                        <a class="nav-link" href="/devices">My pNFT Inventory (10)</a>
                                        <ul class="">
                                            <li class="navbar-item"><a class="nav-link" href="/devices">On Blockchain (7)</a></li>
                                            <li class="navbar-item"><a class="nav-link" href="/devices">Stored Locally (3)</a></li>
                                            <li class="navbar-item"><a class="nav-link" href="#">Sync to Blockchain</a></li>
                                            <li class="navbar-item"><a class="nav-link" href="#">Export to CSV file</a></li>
                                        </ul>
                                    </li>
                                    <li class="navbar-item mt-3">
                                        <span class="nav-link disabled">Manage pNFT Inventory</span>
                                        <ul class="">
                                            <li class="navbar-item"><a class="nav-link" href="{{ route('devices.create') }}">Add Item Online</a></li>
                                            <li class="navbar-item"><a class="nav-link" href="#">Import from CSV file</a></li>
                                        </ul>

                                    </li>
                                    <li class="navbar-item mt-3">
                                        <span class="nav-link disabled">OBD Wallet</span>
                                        <ul class="">
                                            <li class="navbar-item"><a class="nav-link" href="#">Wallet Balance (350 OBD)</a></li>
                                            <li class="navbar-item"><a class="nav-link" href="#">Transfer Funds</a></li>
                                        </ul>

                                    </li>
                                    <li class="navbar-item mt-3"><a class="nav-link" href="#">Documentation</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-9">
                    <main>
                        @yield('page_content')
                    </main>
                </div>
            </div>
        </div>
    </div>

    @include('common.footer')
@endsection
