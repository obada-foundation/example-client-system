@extends('layouts.app-with-nav',[
    'page_title'=>'Manage Accounts',
    'hide_breadcrumbs' => true
])


@section('head')
    <title>Manage Accounts</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
    <script src="{{ mix('/js/base.js') }}"></script>
@endsection


@section('page_bottom')
    <div class="modal" id="phraseConfirmationModal" tabindex="-1" aria-labelledby="phraseConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="phraseConfirmationModalLabel">Warning!</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="my-3">
                        Anyone who knows your seed phrase can control your assets. Proceed?
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                        No, go back
                    </button>
                    <a href="#fullPhraseModal" data-bs-toggle="modal" class="btn btn-primary">
                        Yes, show me full phrase
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="fullPhraseModal" tabindex="-1" aria-labelledby="fullPhraseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="fullPhraseModalLabel">Seed Phrase</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="my-3 text-center">
                        <strong>{{ $seed_phrase }}</strong>
                        <button class="btn btn-link btn-sm" data-copy-text="{{ $seed_phrase }}"><i class="far fa-copy"></i></button>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="exportKeyModal" tabindex="-1" aria-labelledby="exportKeyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="exportKeyModalLabel">Warning!</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="my-3">
                        Anyone who controls your key can control your assets. Proceed?
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                        No, go back
                    </button>
                    <a href="#keyModal" data-bs-toggle="modal" class="btn btn-primary">
                        Yes, show me the key
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="keyModal" tabindex="-1" aria-labelledby="keyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="fullPhraseModalLabel">Key</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="my-3 text-center">
                        <strong class="text-break">E9873D79C6D87DC0FB6A5778633389EXAMPLEKEY3DA61F20BD67FC233AA33262</strong>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('extra_breadcrumbs')
    @if($show_data)
        <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Accounts</a></li>
    @endif
@endsection


@section('page_content')

    @if(!$show_data)
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

        <div class="position-relative mt-5 mb-5">
            <hr>
            <span class="position-absolute top-50 start-50 translate-middle ps-1 pe-1 bg-body text-black-50 lh-1">or</span>
        </div>

        <section class="mb-5">
            <h3>Import existing key:</h3>

            <div class="row">
                <div class="col-12 col-sm-9 col-md-8">
                    <form action="{{ route('accounts.import-account') }}" method="POST" enctype="multipart/form-data" class="row">
                        @csrf

                        <div class="col-12 col-sm-3">
                            <div class="mb-2">
                                <select id="key_type" class="form-select" name="key_type" required>
                                    <option value="">Choose key type</option>
                                    <option value="1">Private Key</option>
                                    <option value="2" disabled>Admin Key</option>
                                    <option value="3" disabled>Read-Only Key</option>
                                </select>
                                @if ($errors->has('key_type'))
                                    <span class="form-helper text-danger">{{ $errors->first('key_type') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                                <input type="file" id="key_value" class="form-control" name="key_value" placeholder="Enter Key" required>
                                @if ($errors->has('key_value'))
                                    <span class="form-helper text-danger">{{ $errors->first('key_value') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <button type="submit" class="btn btn-primary">Proceed</button>
                        </div>
                    </form>
                </div>

                <div class="col-12 col-sm-3 col-md-4">
                    <div class="mt-2 mt-sm-0">Import a single address, not controlled by the seed phrase here.</div>
                </div>
            </div>
        </section>
    @endif

    @if($show_data)

        @if (count($errors))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    swal('Unable to add new account.','{{ ucfirst($errors->first()) }}','error');
                })
            </script>
        @endif

        @if($has_accounts)
            <section class="mb-5">
                <h3 class="d-inline-block">Seed Phrase:</h3> <small class="ms-2"><strong class="fs-5">{{ $seed_phrase_short }}</strong>
                        <a href="#phraseConfirmationModal" class="ms-2 fs-6" data-bs-toggle="modal">Display</a></small>

                <p>
                    <a href="{{ route('accounts.index') }}">Switch Seed Phrase</a>
                </p>

                <p id="phraseFull" class="collapse">

                </p>

                <table class="table mt-5">
                    <thead>
                    <tr>
                        <th>Address</th>
                        <th>OBD Balance</th>
                        <th># pNFTs</th>
                        <th class="text-center">
                            Private Key <!--<small><a href="#" data-bs-toggle="tooltip"
                                                 title='The Master Key (a.k.a. "Owners Key") provides complete control over all attached pNFTs and OBD.  Do not share or lose the Master Key.'><i
                                        class="fas fa-question-circle"></i></a></small>--></th>
                        <th class="text-center">
                            Admin Key <small><a href="#" data-bs-toggle="tooltip"
                                                title='The Admin Key (a.k.a "Management Key") allows the pNFT data to be edited, but does not allow the transfer of the pNFT, nor to any access any OBD attached. Software that manages or updates a pNFT will need to use a Admin Key in order to update the information.'><i
                                        class="fas fa-question-circle"></i></a></small></th>
                        <th class="text-center">
                            Read-Only Key <small><a href="#" data-bs-toggle="tooltip"
                                                    title='The Read-Only Key (or "View Key") decrypts the pNFT data, allowing a third-party to view the pNFT information.'><i
                                        class="fas fa-question-circle"></i></a></small></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                            <tr>
                                <td>
                                    <a href="{{ route('devices.index', $account['address']) }}">{{ $account['short_address'] }}</a>
                                    <button class="btn btn-link btn-sm" data-copy-text="{{ $account['address'] }}"><i class="far fa-copy"></i></button>
                                </td>
                                <td>{{ number_format($account['balance'], 16) }}</td>
                                <td>{{ number_format($account['nft_count'], 0, '.', ',') }}</td>
                                <td class="text-center"><a href="{{ route('accounts.export-account', $account['address']) }}" target="_blank">download</a></td>
                                <td class="text-center">coming soon</td>
                                <td class="text-center">coming soon</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <form action="{{ route('accounts.new-account') }}" method="POST">
                    @csrf
                    <p>
                        <button class="btn btn-primary">+ Generate New Address</button>
                    </p>
                </form>
            </section>
        @endif
    @endif

@endsection
