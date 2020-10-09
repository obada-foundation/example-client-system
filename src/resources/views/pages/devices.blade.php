@extends('layouts.app',['body_class'=>'landing-page'])

@section('head')
    <title>Inventory List</title>
    <meta name="description" content="Obada Reference App Inventory List">
    <meta name="keywords" content="devices">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"/>

@endsection

@section('scripts')

@endsection

@section('content')
    @include('common.nav',['fixed'=>false])
    <div class="main">
        <div class="container">
            <h1 class="text-center">Inventory List</h1>
            <section class="py-5 my-5">
                <device-list></device-list>
            </section>
        </div>

    </div>
    @include('common.footer')
@endsection

@section('scripts')
@endsection
