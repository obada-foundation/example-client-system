@extends('layouts.app-sidenav',[
    'body_class'=>'landing-page',
    'page_title' => 'OBIT Detail'
])


@section('head')
    <title>OBIT Detail</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">

    <link rel="stylesheet" href="{{ mix('/css/app-vue.css') }}">

    <script>
        var _usn = '<?php echo $usn; ?>';
    </script>
@endsection


@section('page_content')

    <obit-detail
        :key="_usn"
        load-obit-url="{{ route('obits.load', $usn) }}"
        to-chain-obit-url="{{ route('obits.to-chain', $usn) }}">
    </obit-detail>

@endsection


@section('scripts')
    <script src="{{ mix('/js/app-vue.js') }}"></script>
@endsection
