@extends('layouts.app-with-nav',[
    'page_title'=>'Manage Addresses'
])


@section('head')
    <title>Manage Addresses</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
    <script src="{{ mix('/js/base.js') }}"></script>
@endsection


@section('page_content')

    <div class="mb-5">
        <h3>Generate New Seed Phrase:</h3>
        <p><a href="{{ route('addresses.generate-phrase') }}?step=1" class="btn btn-primary">Generate</a></p>
    </div>

    <div class="mb-5">
        <h3>Enter Existing Seed Phrase:</h3>
        <div class="row">
            <div class="col-12 col-sm-9 col-md-8">
                <form method="POST" action="{{ route('addresses.save-phrase') }}" class="row">
                    @csrf

                    <div class="col-9">
                        <input type="text" id="seed_phrase" class="form-control" name="seed_phrase" placeholder="Enter Address" required>
                        @if ($errors->has('seed_phrase'))
                            <span class="form-helper text-danger">{{ $errors->first('seed_phrase') }}</span>
                        @endif
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-primary">Proceed</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="mb-5">
        <h3>Enter Existing Address:</h3>
        <div class="row">
            <div class="col-12 col-sm-9 col-md-8">
                <form action="" class="row">
                    <div class="col-3">
                        <select id="key_type" class="form-select" name="key_type" required>
                            <option value="0">Choose key type</option>
                            <option value="1">Master Key</option>
                            <option value="2">Valet Key</option>
                            <option value="3">Read-Only Key</option>
                        </select>
                        @if ($errors->has('key_type'))
                            <span class="form-helper text-danger">{{ $errors->first('key_type') }}</span>
                        @endif
                    </div>
                    <div class="col-6">
                        <input type="text" id="key_value" class="form-control" name="key_value" placeholder="Enter Key" required>
                        @if ($errors->has('key_value'))
                            <span class="form-helper text-danger">{{ $errors->first('key_value') }}</span>
                        @endif
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-primary">Proceed</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($show_data)

        <hr class="mt-5 mb-5">

        <h3>Showing Addresses for Seed Phrase:</h3>
        <p>
            <strong>{{ $seed_phrase_short }}</strong>
            <a href="#phraseFull" class="ms-2" data-bs-toggle="collapse">Display</a>
        </p>

        <p id="phraseFull" class="collapse">
            {{ $seed_phrase }}
            <button class="btn btn-link btn-sm" data-copy-text="{{ $seed_phrase }}"><i class="far fa-copy"></i></button>
        </p>

        <table class="table mt-5">
            <thead>
            <tr>
                <th>Address</th>
                <th>OBD Balance</th>
                <th># pNFTs</th>
                <th class="text-center">Master Key</th>
                <th class="text-center">Valet Key</th>
                <th class="text-center">Read-Only Key</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <span data-bs-toggle="tooltip" title="{{ $address }}">{{ $address_short }}</span>
                        <button class="btn btn-link btn-sm" data-copy-text="{{ $address }}"><i class="far fa-copy"></i></button>
                    </td>
                    <td>1,345.090989809343</td>
                    <td>25,030</td>
                    <td class="text-center"><a href="#">display</a></td>
                    <td class="text-center"><a href="#">generate</a></td>
                    <td class="text-center"><a href="#">generate</a></td>
                </tr>
                <tr>
                    <td>
                        <span data-bs-toggle="tooltip" title="{{ $address }}">{{ $address_short }}</span>
                        <button class="btn btn-link btn-sm" data-copy-text="{{ $address }}"><i class="far fa-copy"></i></button>
                    </td>
                    <td>34.09098912</td>
                    <td>30</td>
                    <td class="text-center"><a href="#">display</a></td>
                    <td class="text-center"><a href="#">generate</a></td>
                    <td class="text-center"><a href="#">generate</a></td>
                </tr>
            </tbody>
        </table>

    @endif

@endsection
