@extends('layouts.app',['body_class'=>'landing-page'])

@section('head')
    <title>Retrieve Obit</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
    <script src="{{ mix('/js/base-vue.js') }}"></script>
@endsection

@section('content')
    @include('common.nav',['fixed'=>false])
    <div class="main">
        <div class="container-lg">
            <h1 class="text-center">Retrieve Obit From Blockchain</h1>
            <section class="py-5 my-5">
                <obit-mapper></obit-mapper>
            </section>
        </div>

    </div>
    @include('common.footer')
@endsection
