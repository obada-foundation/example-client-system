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

    <script>
        function showAlert() {
            swal({
            title: 'All accounts associated with the existing seed phrase will be deleted, including any unsaved local changes. Proceed?',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            },
            function() {
                submit();
            });
        }

        function submit() {
            document.getElementById('import_form').submit();
        }
    </script>
@endsection


@section('extra_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Accounts</a></li>
@endsection


@section('page_content')

        <p>A seed phrase is a set of short words which acts as a “master password”, controlling a list of accounts.
            The accounts under the seed phrase can each contain their own inventory list, and their own amount of OBD.
            An address that is unaffiliated with a seed phrase can also be opened in this wallet.</p>

        <p><strong>Security and Backup</strong><br>
            Backup and keep your seed phrase and all address secure.
            Anyone that knows your seed phrase or keys can control your assets.
            And if they are lost, your data will be unrecoverable.</p>

        <div class="alert alert-warning mt-5" style="max-width: 655px;">
            <small><i class="fas fa-exclamation-triangle me-1"></i></small> <strong>Warning</strong>
            <br>
            Any accounts associated the existing seed phrase will be deleted and replaced.
            <br>
            Stand-alone accounts (those not associated with the current seed phrase) will not be deleted.
        </div>

        <section class="mt-5">
            <h3>Import Seed Phrase:</h3>

            <div class="row">
                <div class="col-12 col-sm-9 col-md-8">
                    <form id="import_form" method="POST" action="{{ route('accounts.import-wallet') }}" class="row">
                        @csrf

                        <div class="col-12 col-sm-9">
                            <div class="mb-3">
                                <input type="text" id="seed_phrase" class="form-control" name="seed_phrase" placeholder="Enter 24 Word Seed Phrase" required>
                                @if ($errors->has('seed_phrase'))
                                    <span class="form-helper text-danger">{{ $errors->first('seed_phrase') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <button class="btn btn-primary" onclick="showAlert();return false;">Proceed</button>
                        </div>
                    </form>
                </div>

                <div class="col-12 col-sm-3 col-md-4">
                    <div class="mt-2 mt-sm-0 mt-md-2">Import an existing list of accounts.</div>
                </div>
            </div>
        </section>

        <section class="mt-4">
            <a href="#" data-bs-toggle="collapse" data-bs-target="#generate_phrase" aria-expanded="false" aria-controls="generate_phrase">Generate New Seed Phrase</a>

            <!-- TODO: replace with AJAX request to get the real seed phrase -->
            <div id="generate_phrase" class="collapse">
                <div class="border pt-4 pb-2 px-4 mt-4">
                    <p>
                        <strong class="fs-5">maze kit advance earn rough cool frequent soon rebuild fan oppose lecture chunk model little agent turtle such spider clay glass hollow into dutch</strong>
                        <button class="btn btn-link btn-sm" data-copy-text="maze kit advance earn rough cool frequent soon rebuild fan oppose lecture chunk model little agent turtle such spider clay glass hollow into dutch"><i class="far fa-copy"></i></button>
                    </p>

                    <div class="alert alert-warning" style="max-width: 550px;">
                        <small><i class="fas fa-exclamation-triangle me-1"></i></small> <strong>Save this phrase somewhere safe</strong>
                        <br>
                        Anyone who knows your seed phrase can control all of your assets.
                        <br>
                        If you lose the seed phrase, you will lose access, and it can't be recovered.
                    </div>

                    <p>
                        <a href="#" data-bs-toggle="collapse" data-bs-target="#generate_phrase" aria-expanded="false" aria-controls="generate_phrase">I saved the seed phrase</a>
                    </p>
                </div>
            </div>
        </section>

@endsection
