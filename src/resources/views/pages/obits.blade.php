@extends('layouts.app',['body_class'=>'landing-page'])

@section('head')
    <title>Local Obits</title>
    <meta name="description" content="Local inventory of Obits">
    <meta name="keywords" content="obits, list">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"/>

@endsection

@section('scripts')

@endsection

@section('content')
    @include('common.nav',['fixed'=>false])
    <div class="main">
        <div class="container-md">
            <h1 class="text-center">Local OBITs</h1>
            <section class="py-5 my-5">
                <obit-list></obit-list>
            </section>
        </div>

    </div>
    @include('common.footer')
@endsection

@section('scripts')
@endsection
