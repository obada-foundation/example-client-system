@extends('layouts.app',['body_class'=>'landing-page'])

@section('head')
    <title>__title__</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">

@endsection

@section('scripts')

@endsection

@section('content')
    @include('common.nav',['fixed'=>false])
    <div class="main">
        <div class="container">
            <section class="py-5 my-5">
                <h5>Links</h5>
                <a href="/devices">Device List</a> <br>
                <a href="/obits">Obit List</a> <br>
                <a href="/devices/0/edit">Add New Device</a> <br>
                <a href="/generate/usn">Generate USN</a> <br>
            </section>
        </div>

    </div>
    @include('common.footer')
@endsection
