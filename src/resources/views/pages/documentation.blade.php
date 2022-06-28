@extends('layouts.app-with-nav',[
    'page_title'=>'Documentation'
])


@section('head')
    <title>Documentation</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
    <script src="{{ mix('/js/base.js') }}"></script>
@endsection


@section('page_content')

    @include('common.documentation-list')

@endsection
