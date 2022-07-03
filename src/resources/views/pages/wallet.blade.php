@extends('layouts.app-with-nav',[
    'page_title'=>'Wallet'
])


@section('head')
    <title>Wallet</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
    <script src="{{ mix('/js/base.js') }}"></script>
@endsection


@section('page_content')

    <div class="card mb-5">
        <div class="card-body">
            <ul class="list-group list-group-flush mt-3 mb-3">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>My Address</strong>
                        </div>
                        <div class="col-md-9">
                            dfgsdsgsdfgdfgdfg<button class="btn btn-link btn-sm" data-copy-text="dfgsdsgsdfgdfgdfg"><i class="far fa-copy"></i></button>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Wallet Balance</strong>
                        </div>
                        <div class="col-md-9">
                            732 OBD
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="">
                <div class="mt-2 mb-4">
                    <div class="row">
                        <div class="col-12 col-md-10">
                            <label for="address" class="form-label">Send OBD to address</label>
                            <input id="address" name="address" type="text" class="form-control" placeholder="Enter recipient address">
                        </div>
                        <div class="col-12 col-md-2">
                            <button class="btn btn-primary w-100" style="margin-top: 2rem;">Send</button>
                        </div>
                    </div>
                </div>

                <p><a href="">Get OBD for testing at the OBADA OBD Faucet</a></p>
            </form>
        </div>
    </div>

@endsection
