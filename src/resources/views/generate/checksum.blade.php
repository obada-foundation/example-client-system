@extends('layouts.app')

@section('head')
    <title>Generate Checksum</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
    <script src="{{ mix('/js/base-vue.js') }}"></script>
@endsection


@section('content')
    @include('common.nav',['fixed'=>false])
    <div class="main">
        <div class="container">
            <h1 class="text-center">Generate Checksum</h1>
            <section class="py-5 my-5">
                <checksum-generator submit-url="{{ route('generate.checksum.compute') }}"></checksum-generator>
            </section>
        </div>

    </div>
    @include('common.footer')
@endsection
