@extends('layouts.app-with-nav', [
    'page_title' => 'Transfer pNFT — USN ' . $usn
])

@section('head')
    <title>Transfer pNFT — USN {{ $usn }}</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection

@section('scripts')
    <script src="{{ mix('/js/base.js') }}"></script>
@endsection

@section('page_content')
    <input type="hidden" name="usn" value="{{ $usn }}">

    <h2>Step 1: Specify Asset Recipient</h2>
    <div class="card">
        <div class="card-body">
            <div class="mt-3 mb-3">
                <label for="" class="form-label">Transfer to</label>
                <input type="text" placeholder="Insert JSON Web Token" class="form-control">
                <div class="form-text">The receiver must provide you a JSON Web Token to verify their identity.</div>
            </div>
        </div>
    </div>

    <h2 class="mt-5">Step 2: Accept Legal Agreement</h2>
    <div class="card">
        <div class="card-body">
            <div class="mt-3 mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" value="1" id="legal_agreement" required>
                    <label for="legal_agreement" class="form-check-label">Legal agreement. <br>I attest that I legally own the physical asset represented by this pNFT. I understand that transferring this pNFT also represents a transfer in legal ownership of the physical asset.</label>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">Preview</button>
        <p class="mt-3">Authorization code will be send to your phone for verification.</p>
    </div>

@endsection


@section('page_bottom')
    <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="exampleModalLabel">2FA Verification</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="my-3">
                        <p><strong>A code has been sent to your phone to authorize your identity.</strong></p>
                        <label for="" class="form-label">Enter authorization code</label>
                        <input type="text" class="form-control" value="111111">
                        <div class="form-text">This is just a demo. No code is needed. Just click Continue.</div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#networkFeesModal">Continue</button>
                </div>
            </div>
        </div>
    </div>


    @include('common.network-fees-modal')
@endsection
