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
    <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Accounts</a></li>
    <li class="breadcrumb-item"><a href="{{ route('devices.index', $address) }}">{{ $address_short }}</a></li>
@endsection


@section('page_content')
    <form action="{{ route('devices.import.handle', $address) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="csv" class="form-label">Cut & paste an inventory list in CSV format, one row per device using this column order: manufacturer, part number or model, serial number</label>
            <textarea id="csv" name="csv" class="form-control" rows="5" placeholder="Enter CSV content">{{ old('csv') }}</textarea>

            @if ($errors->has('csv'))
                <span class="form-helper text-danger">{{ $errors->first('csv') }}</span>
            @endif
        </div>

        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
    </form>
@endsection
