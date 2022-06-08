@extends('layouts.app',['body_class'=>$body_class])

@section('content')
    @include('common.nav',['fixed'=>false])

    <div class="main">
        <div class="container">
            <h1>{{ $page_title }}</h1>

            <div class="row">
                <div class="col-xs-12 col-md-3">
                    <div class="card mt-0">
                        <div class="card-body">
                            <nav class="nav flex-column">
                                <a class="nav-link" href="/">Home</a>
                                <a class="nav-link" href="/devices">My Inventory</a>
                                <a class="nav-link" href="{{ route('devices.create') }}">Add New Part</a>
                                <a class="nav-link" href="#">Help</a>
                                <a class="nav-link" href="{{ route('logout') }}">Logout</a>
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
