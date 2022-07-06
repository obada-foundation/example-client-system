@extends('layouts.app')

@section('content')
    @include('common.nav',['fixed'=>false])

    <div class="border-top border-bottom">
        <div class="container-lg">
            <ul class="nav">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">My Inventory</a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a href="{{ route('devices.index') }}">View Inventory List</a></li>
                        <li class="dropdown-item"><a href="{{ route('devices.create') }}">Add New Device</a></li>
                        <li class="dropdown-item disabled"><span>Export to CSV file <em>(coming soon)</em></span></li>
                        <li class="dropdown-item disabled"><span>Import from CSV file <em>(coming soon)</em></span></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="{{ route('wallet.index') }}" class="nav-link">Wallet</a></li>
                <li class="nav-item"><a href="{{ route('documentation') }}" class="nav-link">Documentation</a></li>
            </ul>
        </div>
    </div>

    <div class="main">
        <div class="container-lg">
            @if(isset($has_title_action) && $has_title_action)
                <div class="d-md-flex justify-content-between align-items-center mb-5">
                    <h1 class="mb-4 mb-md-0">{{ $page_title }}</h1>
                    @yield('title_action')
                </div>
            @else
                <h1 class="mb-5">{{ $page_title }}</h1>
            @endif

            <main class="position-relative">
                @yield('page_content')
            </main>
        </div>
    </div>

    @include('common.footer')
@endsection
