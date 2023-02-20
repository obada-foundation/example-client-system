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
                    <a href="#twoFaModal" data-bs-toggle="modal" class="btn btn-primary">
                        Yes, show me full phrase
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="twoFaModal" tabindex="-1" aria-labelledby="twoFaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="twoFaModalLabel">2FA Verification</h4>
                    <button ref="CloseTwoFa" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="my-3">
                        <p><strong>A code has been sent to your phone to authorize your identity.</strong></p>
                        <label for="" class="form-label">Enter authorization code</label>
                        <input type="text" class="form-control" value="111111">
                        <div class="form-text">This is just a demo. No code is needed. Just click Confirm.</div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <a href="#fullPhraseModal" data-bs-toggle="modal" class="btn btn-primary">
                        Confirm
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
                        <!-- todo: fix functionality -->
{{--                        <button class="btn btn-link btn-sm" data-copy-text="{{ $seed_phrase }}"><i class="far fa-copy"></i></button>--}}
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
                    swal('Unable to complete operation.','{{ ucfirst($errors->first()) }}','error');
                })
            </script>
        @endif

        <p class="mb-5">Your inventory is stored in accounts which act as an independent lots for your assets. Each account carries a separate system credit balance. The main accounts are all derived from a single seed phrase, but accounts can also be independently imported and exported.</p>

        <section class="mb-5">
            <h3 class="d-inline-block">Main Accounts</h3>
            <p>
                @if ($seed_phrase_short)
                    This account are derived from the seed phrase "{{ $seed_phrase_short }}"
                    (<a href="#phraseConfirmationModal" data-bs-toggle="modal">display</a>)
                    <span class="ms-2 me-2 text-muted">|</span>
                    <a href="{{ route('accounts.manage') }}">Switch Seed Phrase</a>
                @else
                    <a href="{{ route('accounts.manage') }}">Enter a Seed Phrase</a>
                @endif
            </p>

            @include('accounts.includes.accounts-table', [
                'accounts'       => $hd_accounts,
                'noAccountsText' => 'No accounts.',
                'canDelete'      => false
            ])

            <form action="{{ route('accounts.new-account') }}" method="POST">
                @csrf
                <p>
                    <button class="btn btn-primary">+ Generate New Account</button>
                </p>
            </form>
        </section>

        <hr class="mt-5 mb-5">

        <section class="mb-5">
            <h3>Imported Accounts</h3>
            <p>This standalone accounts are individually imported and not derived from the seed phrase above.</p>

            @include('accounts.includes.accounts-table', [
                'accounts'       => $imported_accounts,
                'noAccountsText' => 'No imported accounts.',
                'canDelete'      => true
            ])

            <p>
                <a href="{{ route('accounts.import-account') }}" class="btn btn-link text-decoration-none">Import Standalone Account</a>
            </p>
        </section>
@endsection
