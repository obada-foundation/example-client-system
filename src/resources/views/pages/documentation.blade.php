@extends('layouts.app-sidenav',[
    'body_class'=>'landing-page',
    'page_title'=>'Documentation'
])


@section('head')
    <title>Documentation</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('page_content')

    @include('common.documentation-list')

@endsection
