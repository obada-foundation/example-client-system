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


@section('page_content')

        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    swal('Unable to add new account.','{{ ucfirst($errors->first()) }}','error');
                })
            </script>
        @endif

        <p class="mb-5">Your inventory is stored in accounts which act as an independent lots for your assets. Each account carries a separate system credit balance. The main accounts are all derived from a single seed phrase, but accounts can also be independently imported and exported.</p>

        <section class="mb-5">
            <h3 class="d-inline-block">Main Accounts</h3>
            <p>
                This account are derived from the seed phrase.
                <span class="ms-2 me-2 text-muted">|</span>
                <a href="{{ route('accounts.manage') }}">Switch Seed Phrase</a>
            </p>

            <table class="table mt-4">
                <thead>
                <tr>
                    <th>Address (Lot Name)</th>
                    <th>System Credits (OBD)</th>
                    <th># Assets (pNFTs)</th>
                    <th class="text-center">
                        Private Key <small><a href="#" data-bs-toggle="tooltip"
                                             title='The private key is for the asset owner. It provides full access to the data, including transferring the pNFT and the OBD system credits. Loss of the key could result in loss of the asset.'><i
                                    class="fas fa-question-circle"></i></a></small></th>
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
                    @forelse($hd_accounts as $account)
                        <tr>
                            <td>
                                <a href="{{ route('devices.index', $account['address']) }}">{{ $account['name'] }}</a>
{{--                                <button class="btn btn-link btn-sm" data-copy-text="{{ $account['address'] }}"><i class="far fa-copy"></i></button>--}}
                            </td>
                            <td class="text-center">{{ number_format($account['balance'], 2) }}</td>
                            <td class="text-center">{{ number_format($account['nft_count'], 0, '.', ',') }}</td>
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
                    <button class="btn btn-primary">+ Generate New Account</button>
                </p>
            </form>
        </section>

        <hr class="mt-5 mb-5">

        <section class="mb-5">
            <h3>Imported Accounts</h3>
            <p>This standalone accounts are individually imported and not derived from the seed phrase above.</p>

            <table class="table mt-4">
                <thead>
                <tr>
                    <th>Address (Lot Name)</th>
                    <th>System Credits (OBD)</th>
                    <th># Assets (pNFTs)</th>
                    <th class="text-center">
                        Private Key <small><a href="#" data-bs-toggle="tooltip"
                                              title='The private key is for the asset owner. It provides full access to the data, including transferring the pNFT and the OBD system credits. Loss of the key could result in loss of the asset.'><i
                                    class="fas fa-question-circle"></i></a></small></th>
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
                @forelse($imported_accounts as $account)
                    <tr>
                        <td>
                            <a href="{{ route('devices.index', $account['address']) }}">{{ $account['name'] }}</a>
{{--                            <button class="btn btn-link btn-sm" data-copy-text="{{ $account['address'] }}"><i class="far fa-copy"></i></button>--}}
                        </td>
                        <td class="text-center">{{ number_format($account['balance'], 2) }}</td>
                        <td class="text-center">{{ number_format($account['nft_count'], 0, '.', ',') }}</td>
                        <td class="text-center"><a href="{{ route('accounts.export-account', $account['address']) }}" target="_blank">download</a></td>
                        <td class="text-center">coming soon</td>
                        <td class="text-center">coming soon</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No imported accounts.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <p>
                <a href="{{ route('accounts.import-account') }}" class="btn btn-link text-decoration-none">Import Standalone Account</a>
            </p>
        </section>
@endsection
