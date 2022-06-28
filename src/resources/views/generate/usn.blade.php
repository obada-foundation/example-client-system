@extends('layouts.app')

@section('head')
    <title>Generate USN</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
    <script src="{{ mix('/js/base-vue.js') }}"></script>
@endsection


@section('content')
    @include('common.nav', ['fixed' => false])
    <div class="main">
        <div class="container-lg">
            <h1 class="text-center">Generate USN</h1>
            <section class="py-5 my-5">
                <usn-generator submit-url="{{ route('generate.usn.compute') }}"></usn-generator>
            </section>
        </div>
    </div>
    @include('common.footer')
@endsection
