@extends('layouts.app-with-nav', [
    'page_title' => 'Transfer pNFT — USN ' . $usn,
    'breadcrumb_name' => 'Transfer pNFT'
])


@section('head')
    <title>Transfer pNFT — USN {{ $usn }}</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
    <script src="{{ mix('/js/nft_transfer.js') }}"></script>
@endsection


@section('extra_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Accounts</a></li>
    <li class="breadcrumb-item"><a href="{{ route('devices.index', $address) }}">{{ $address_short }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('devices.show', $usn) }}">{{ $usn }}</a></li>
@endsection


@section('page_content')
    <nft-transfer
        :devices-overview-url="'{{ route('devices.index', $address) }}'"
        :send-nft-url="'{{ route('nft.transfer.send', $usn) }}'"
        :usn="'{{ $usn }}'"
    ></nft-transfer>
@endsection
