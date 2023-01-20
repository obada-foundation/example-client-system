@extends('layouts.app')

@section('content')
    @include('common.nav',['fixed'=>false])

    <div class="border-top border-bottom">
        <div class="container-lg">
            <ul class="nav">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link ps-0 dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">Account</a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a href="{{ route('accounts.index') }}">Switch Seed Phrase</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="{{ route('documentation') }}" class="nav-link">Documentation</a></li>
            </ul>
        </div>
    </div>

    <div class="main">
        <div class="container-lg">
            @if(isset($has_title_action) && $has_title_action)
                <div class="d-md-flex justify-content-between align-items-center mb-2">
                    <h1 class="mb-2 mb-md-0">{{ $page_title }}</h1>
                    @yield('title_action')
                </div>
            @else
                @if(!(isset($hide_h1) && $hide_h1))
                    <h1>{{ $page_title }}</h1>
                @endif
            @endif

            @if(!(isset($hide_breadcrumbs) && $hide_breadcrumbs))
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        @yield('extra_breadcrumbs')
                        <li class="breadcrumb-item active" aria-current="page">{{ $page_title }}</li>
                    </ol>
                </nav>
            @endif

            <main class="position-relative mt-5">
                @yield('page_content')
            </main>
        </div>
    </div>

    @include('common.footer')
@endsection
