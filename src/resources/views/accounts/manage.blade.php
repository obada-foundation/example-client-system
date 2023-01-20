@extends('layouts.app-with-nav',[
    'page_title'=>'Manage Seed Phrase',
])


@section('head')
    <title>Manage Seed Phrase</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
    <script src="{{ mix('/js/base.js') }}"></script>
@endsection


@section('extra_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Accounts</a></li>
@endsection


@section('page_content')

        <p>A seed phrase is a set of short words which acts as a “master password”, controlling a list of accounts. <br>
            The accounts under the seed phrase can each contain their own inventory list, and their own amount of OBD. <br>
            An address that is unaffiliated with a seed phrase can also be opened in this wallet.</p>

        <p><strong>Security and Backup</strong><br>
            Backup and keep your seed phrase and all address secure. Anyone that knows your seed phrase or keys can control your assets. And if they are lost, your data will be unrecoverable.</p>

        <section class="mt-5 mb-5">
            <h3>Generate New Seed Phrase:</h3>

            <div class="row">
                <div class="col-12 col-sm-9 col-md-8">
                    <p class="mb-0"><a href="{{ route('accounts.generate-phrase') }}?step=1" class="btn btn-primary">Generate</a></p>
                </div>

                <div class="col-12 col-sm-3 col-md-4">
                    <div class="mt-2 mt-sm-0">This will allow you to generate a new list of accounts.</div>
                </div>
            </div>
        </section>

        <div class="position-relative mt-5 mb-5">
            <hr>
            <span class="position-absolute top-50 start-50 translate-middle ps-1 pe-1 bg-body text-black-50 lh-1">or</span>
        </div>

        <section class="mb-5">
            <h3>Import Seed Phrase:</h3>

            <div class="row">
                <div class="col-12 col-sm-9 col-md-8">
                    <form method="POST" action="{{ route('accounts.import-wallet') }}" class="row">
                        @csrf

                        <div class="col-12 col-sm-9">
                            <div class="mb-3">
                                <input type="text" id="seed_phrase" class="form-control" name="seed_phrase" placeholder="Enter Address" required>
                                @if ($errors->has('seed_phrase'))
                                    <span class="form-helper text-danger">{{ $errors->first('seed_phrase') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <button type="submit" class="btn btn-primary">Proceed</button>
                        </div>
                    </form>
                </div>

                <div class="col-12 col-sm-3 col-md-4">
                    <div class="mt-2 mt-sm-0 mt-md-2">Import an existing list of accounts.</div>
                </div>
            </div>
        </section>

        <section class="mt-5 mb-5">
            <p>You can also <a href="{{ route('accounts.import-account') }}">import existing key</a>.</p>
        </section>

@endsection
