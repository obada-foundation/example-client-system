@extends('layouts.app-with-nav',[
    'page_title'=>'Accounts',
])


@section('head')
    <title>Accounts</title>
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
@endsection


@section('page_content')

        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    swal('Unable to add new account.','{{ ucfirst($errors->first()) }}','error');
                })
            </script>
        @endif

        <section class="mb-5">
            <h3 class="d-inline-block">Seed Phrase:</h3>
            <small class="ms-2"><strong class="fs-5">{{ $seed_phrase_short }}</strong>
            <a href="#phraseConfirmationModal" class="ms-2 fs-6" data-bs-toggle="modal">Display</a></small>
            <span class="ms-2 me-2 text-muted">|</span>
            <a href="{{ route('accounts.manage') }}">Switch Seed Phrase</a>

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
                    @forelse($accounts as $account)
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
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No accounts.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <form action="{{ route('accounts.new-account') }}" method="POST">
                @csrf
                <p>
                    <button class="btn btn-primary">+ Generate New Address</button>
                </p>
            </form>
        </section>

@endsection
