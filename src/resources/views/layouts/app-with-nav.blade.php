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
                        <li class="dropdown-item disabled"><span>Export to CSV file</span></li>
                        <li class="dropdown-item disabled"><span>Import from CSV file</span></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="#" class="nav-link">OBD Wallet</a></li>
                <li class="nav-item"><a href="{{ route('documentation') }}" class="nav-link">Documentation</a></li>
            </ul>
        </div>
    </div>

    <div class="main">
        <div class="container-lg">
            <h1 class="mb-5">{{ $page_title }}</h1>

            <main class="position-relative">
                @yield('page_content')
            </main>
        </div>
    </div>

    @include('common.footer')
@endsection
