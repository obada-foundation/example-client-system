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

            </section>
        </div>

    </div>
    @include('common.footer')
@endsection
