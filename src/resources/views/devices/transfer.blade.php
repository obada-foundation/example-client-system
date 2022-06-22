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
                    <input type="text" placeholder="JWT token" class="form-control">
                </div>

                <h4 class="mt-2">Transaction fee:</h4>
                <table class="table table-sm table-bordered mb-5">
                    <tbody>
                    <tr>
                        <td>Gas Fee (node fee set by the DAO)</td>
                        <td class="text-end">0.001 OBD</td>
                    </tr>
                    <tr>
                        <td>IPFS Storage Charge (file storage fee set by the DAO)</td>
                        <td class="text-end">0.001 OBD</td>
                    </tr>
                    <tr>
                        <td>Service Fee (gateway fee)</td>
                        <td class="text-end">0.001 OBD</td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td class="text-end"><strong>0.003 OBD</strong></td>
                    </tr>
                    </tbody>
                </table>

                <h2 class="mb-5 text-center">2FA</h2>

                <div class="text-center mt-5">
                    <button class="btn btn-primary btn-lg">Send</button>
                </div>
            </form>
        </div>
    </div>
@endsection
