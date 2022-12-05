@extends('layouts.app')

@section('content')
    @include('common.nav',['fixed'=>false])

    <div class="main">
        <div class="container-lg">
            @if(isset($has_title_action) && $has_title_action)
                <div class="d-md-flex justify-content-between align-items-center mb-2">
                    <h1 class="mb-2 mb-md-0">{{ $page_title }}</h1>
                    @yield('title_action')
                </div>
            @else
                <h1>{{ $page_title }}</h1>
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
