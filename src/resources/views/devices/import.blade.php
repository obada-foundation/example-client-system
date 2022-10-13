@extends('layouts.app-with-nav',[
    'page_title' => $page->title
])


@section('head')
    <title>{{ $page->title }}</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
@endsection


@section('extra_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('devices.index') }}">Wallet</a></li>
@endsection


@section('page_content')
    <form action="">
        <div class="mb-4">
            <label for="csv" class="form-label">Cut & paste an inventory list in CSV format, one row per device using this column order: manufacturer, part number or model, serial number, link to info</label>
            <textarea id="csv" name="csv" class="form-control" rows="5" placeholder="Enter CSV content"></textarea>
        </div>

        <button class="btn btn-primary btn-lg">Submit</button>
    </form>
@endsection
