@extends('layouts.app',['body_class'=>$body_class])

@section('content')
    @include('common.nav',['fixed'=>false])

    <div class="main">
        <div class="container-md">
            <h1>{{ $page_title }}</h1>

            <nav aria-label="Breadcrumb" class="breadcrumb">
                <a href="/" class="breadcrumb-item">Home</a>
                <span aria-current="page" class="breadcrumb-item active">{{ $page_title }}</span>
            </nav>

            <div class="card bg-transparent mb-5">
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link" href="{{ route('devices.index') }}">My Inventory
                            <span class="badge bg-danger rounded-pill position-relative" style="top: -2px;">10</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('devices.create') }}">Create pNFT</a></li>
                    <li class="nav-item"><span class="nav-link disabled">Export to CSV file</span></li>
                    <li class="nav-item"><span class="nav-link disabled">Import from CSV file</span></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">OBD Wallet</a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item"><a href="#">Wallet Balance (350 OBD)</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('documentation') }}">Documentation</a></li>
                </ul>
            </div>

            <main>
                @yield('page_content')
            </main>
        </div>
    </div>

    @include('common.footer')
@endsection
