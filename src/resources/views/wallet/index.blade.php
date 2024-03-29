@extends('layouts.app-with-nav',[
    'page_title'=>'Manage OBD'
])


@section('head')
    <title>Manage OBD</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
    <script src="{{ mix('/js/wallet_index.js') }}"></script>
@endsection


@section('extra_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Accounts</a></li>
    <li class="breadcrumb-item"><a href="{{ route('devices.index', $account->getAddress()) }}">{{ $account->getBreadCrumbsAddress() }}</a></li>
@endsection


@section('page_content')

    <div class="mb-5">
        <h3>Address:</h3>
        <p>{{ $account->getAddress() }}<button class="btn btn-link btn-sm"
                                 data-copy-text="{{ $account->getAddress() }}"><i class="far fa-copy"></i></button></p>
    </div>


    <div class="mb-5">
        <h3>To Send OBD:</h3>
        <div class="row">

            @if ($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        swal('Unable to send coins.','{{ ucfirst($errors->first()) }}','error');
                    })
                </script>
            @endif

            <div class="col-12 col-sm-9 col-md-6">
                <form id="wallet_send_form" action="{{ route('wallet.send', $account->getAddress()) }}" method="POST" class="row">
                    @csrf

                    <div class="col-12 mb-2">
                        <input type="text" id="recipient_address" class="form-control" name="recepient_address"
                               placeholder="Enter Receiver Address" value="{{ old('recepient_address') }}" required>
                        @if ($errors->has('recepient_address'))
                            <span class="form-helper text-danger">{{ $errors->first('recepient_address') }}</span>
                        @endif
                    </div>

                    <div class="col-7">
                        <input type="text" class="form-control" name="amount" placeholder="Enter OBD amount"
                               value="{{ old('amount') }}"
                               data-total="{{ $account->getFormattedBalance() }}"
                               data-gas-fee="{{ config('app.gas_fee') }}"
                               required>
                        <p class="mb-0 ms-2 text-black-40">Available balance &mdash; {{ $account->getFormattedBalance() }} OBD</p>
                    </div>

                    <div class="col-5">
                        <button type="submit" class="btn btn-primary w-100" disabled>Send</button>
                        <p class="mb-0 text-black-40 text-center">{{ config('view.gas_fee_text') }}</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="mb-5">
        <h3>To Receive OBD:</h3>
        <p>Tell the sender to send to <strong>{{ $account->getAddress() }}</strong><button class="btn btn-link btn-sm"
                                                                             data-copy-text="{{ $account->getAddress() }}"><i class="far fa-copy"></i></button></p>
    </div>

    @if (env('APP_ENV') != 'production')
        <div class="mb-5">
            <h3>OBADA Faucet:</h3>
            <p><a target="_blank" href="{{ config('faucet.url') }}">Get a small amount for testing</a></p>
        </div>
    @endif

@endsection
