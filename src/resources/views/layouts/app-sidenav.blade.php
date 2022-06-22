@extends('layouts.app',['body_class'=>$body_class])

@section('content')
    @include('common.nav',['fixed'=>false])

    <div class="border-top border-bottom">
        <div class="container-md">
            <ul class="nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">My Inventory</a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a href="{{ route('devices.index') }}">View</a></li>
                        <li class="dropdown-item"><a href="{{ route('devices.create') }}">Create pNFT</a></li>
                        <li class="dropdown-item disabled"><span>Export to CSV file</span></li>
                        <li class="dropdown-item disabled"><span>Import from CSV file</span></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="#" class="nav-link">OBD Wallet (350 OBD)</a></li>
                <li class="nav-item"><a href="{{ route('documentation') }}" class="nav-link">Documentation</a></li>
            </ul>
        </div>
    </div>

    <div class="main">
        <div class="container-md">
            <h1 class="mb-4">{{ $page_title }}</h1>

            <main>
                @yield('page_content')
            </main>
        </div>
    </div>

    @include('common.footer')
@endsection
