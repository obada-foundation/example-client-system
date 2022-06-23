@extends('layouts.app-sidenav', [
    'body_class' => 'landing-page',
    'page_title' => 'Transfer pNFT — USN ' . $usn
])

@section('head')
    <title>Transfer pNFT — USN {{ $usn }}</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection

@section('scripts')
@endsection

@section('page_content')
    <div class="card">
        <div class="card-body">
            <form class="mt-3 mb-3" action="">
                <input type="hidden" name="usn" value="{{ $usn }}">

                <div class="mb-5">
                    <label for="" class="form-label">Transfer to</label>
                    <input type="text" placeholder="Insert JSON Web Token" class="form-control">
                    <div class="form-text">The receiver must provide you a JSON Web Token to verify their identity.</div>
                </div>

                <h4 class="mt-2">Transaction fee:</h4>
                <div class="row">
                    <div class="col-0 col-md-6 d-flex align-items-center">
                        <p>System fees, such as gas, storage and the Recycling Incentive, are set by the DAO and distributed equally to the operating DAO nodes. Third-party applications and off-chain services charge their fees separately.</p>
                    </div>
                    <div class="col-12 col-md-6">
                        <table class="table" style="vertical-align: middle;">
                            <tbody>
                            <tr>
                                <td><strong>Gas Fee</strong> <br> <small>Validator node fee.</small></td>
                                <td class="text-end">0.001 OBD</td>
                            </tr>
                            <tr>
                                <td><strong>Storage Charge</strong><br><small>File storage costs.</small></td>
                                <td class="text-end">0.001 OBD</td>
                            </tr>
                            <tr>
                                <td><strong>Application Fee</strong><br><small>Gateway usage fee.</small></td>
                                <td class="text-end">0.001 OBD</td>
                            </tr>
                            <tr>
                                <td><strong>Recycling Incentive</strong> <em>(optional)</em><br><small>Will be returned when the device is recycled.</small></td>
                                <td class="text-end">1 OBD</td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td class="border-0"><strong class="fs-5">Total</strong></td>
                                <td class="border-0 text-end"><strong class="fs-5">0.003 OBD</strong></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

{{--                <h2 class="mb-5 text-center">2FA</h2>--}}

                <div class="text-center mt-5">
                    <button class="btn btn-primary btn-lg">Preview</button>
                    <p class="mt-3">Authorization code will be send to your phone for verification.</p>
                </div>
            </form>
        </div>
    </div>
@endsection
