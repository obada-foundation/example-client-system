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
        <th class="text-center" style="width: 30px;"></th>
    </tr>
    </thead>
    <tbody>
    @forelse($accounts as $account)
        <tr data-id="{{ $account->getAddress() }}">
            <td>
                @if($account->getName())
                    <span class="text-break">{{ $account->getName() }}</span>
                    <span class="text-nowrap">( <a href="{{ route('devices.index', $account->getAddress()) }}">...{{ substr($account->getAddress(), -4) }}</a>
                                <button class="btn btn-link btn-sm ps-2 pe-1" data-copy-text="{{ $account->getAddress() }}"><i class="far fa-copy"></i></button>)</span>
                @else
                    <a href="{{ route('devices.index', $account->getAddress()) }}">{{ $account->getShortAddress() }}</a>
                    <button class="btn btn-link btn-sm px-2" data-copy-text="{{ $account->getAddress() }}"><i class="far fa-copy"></i></button>
                @endif
            </td>
            <td class="text-center">{{ $account->getFormattedBalance() }}</td>
            <td class="text-center">{{ $account->getFormattedNftCount() }}</td>
            <td class="text-center"><a href="{{ route('accounts.export-account', $account->getAddress()) }}" target="_blank">download</a></td>
            <td class="text-center">coming soon</td>
            <td class="text-center">coming soon</td>
            <td class="text-center" style="width: 30px;">
                <span data-bs-toggle="tooltip" title="Delete Account">
                    <button class="btn btn-link btn-sm ps-2 pe-2"
                            data-action="delete-account"
                            data-id="{{ $account->getAddress() }}"
                            data-short-id="{{ $account->getShortAddress() }}"
                            data-delete-url="{{ route('accounts.delete-account', $account->getAddress()) }}"><i class="fas fa-trash-alt"></i></button>
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">
                {{ isset($noAccountsText) ? $noAccountsText : 'No accounts.' }}
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
