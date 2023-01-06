@extends('layouts.app-with-nav',[
    'page_title'=>'Wallet Details'
])


@section('head')
    <title>Wallet</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
    <script src="{{ mix('/js/base.js') }}"></script>
@endsection


@section('extra_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('devices.index', $address) }}">Wallet</a></li>
@endsection


@section('page_content')

    <div class="mb-5">
        <h3>Address:</h3>
        <p>{{ $address }}<button class="btn btn-link btn-sm"
                                 data-copy-text="{{ $address }}"><i class="far fa-copy"></i></button></p>
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
                <form action="{{ route('wallet.send', $address) }}" method="POST" class="row">
                    @csrf
                    
                    <div class="col-9">
                        <input type="text" class="form-control" name="amount" placeholder="OBD amount" value="{{ old('amount') }}" required>
                    </div>

                    <div class="col-9">
                        <input type="text" id="address" class="form-control" name="recepient_address"
                               placeholder="Enter Receiver Address" value="{{ old('recepient_address') }}" required>
                        @if ($errors->has('recepient_address'))
                            <span class="form-helper text-danger">{{ $errors->first('recepient_address') }}</span>
                        @endif
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-primary w-100">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="mb-5">
        <h3>To Receive OBD:</h3>
        <p>Tell the sender to send to <strong>{{ $address }}</strong><button class="btn btn-link btn-sm"
                                                                             data-copy-text="{{ $address }}"><i class="far fa-copy"></i></button></p>
    </div>

    @if (env('APP_ENV') != 'production')
        <div class="mb-5">
            <h3>OBADA Faucet:</h3>
            <p><a target="_blank" href="{{ config('faucet.url') }}">Get a small amount for testing</a></p>
        </div>
    @endif

@endsection
