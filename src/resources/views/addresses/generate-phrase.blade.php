@extends('layouts.app-with-nav',[
    'page_title'=>$page_title
])


@section('head')
    <title>{{ $page_title }}</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
    <script src="{{ mix('/js/base.js') }}"></script>
@endsection


@section('page_content')

    @if($step == 1)

        <div class="mb-5">
            <h3>New Seed Phrase:</h3>
            <div class="alert alert-warning d-inline-block">
                <small><i class="fas fa-exclamation-triangle me-1"></i></small> Save this phrase somewhere safe
            </div>
            <p>
                <strong>{{ $seed_phrase }}</strong>
                <button class="btn btn-link btn-sm" data-copy-text="{{ $seed_phrase }}"><i class="far fa-copy"></i></button>
            </p>
        </div>

        <div class="mb-5">
            <h3>Enter two random words from new phrase to confirm:</h3>
            <div class="row">
                <div class="col-12 col-sm-9 col-md-8">
                    <form method="POST" action="{{ route('addresses.save-phrase') }}" class="row">
                        @csrf

                        <div class="col-9">
                            <input type="text" id="phrase_words" class="form-control" name="phrase_words" placeholder="Enter words here" required>
                            @if ($errors->has('phrase_words'))
                                <span class="form-helper text-danger">{{ $errors->first('phrase_words') }}</span>
                            @endif
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @elseif($step == 2)

        <div class="alert alert-success d-inline-block mb-5">
            <small><i class="fas fa-check me-1"></i></small> Seed phrase successfully saved
        </div>

        <div class="mb-5">
            <h3>Seed Phrase:</h3>

            <p>
                <strong>{{ $seed_phrase_short }}</strong>
                <a href="#phraseFull" class="ms-2" data-bs-toggle="collapse">Display</a>
            </p>

            <p id="phraseFull" class="collapse">
                {{ $seed_phrase }}
                <button class="btn btn-link btn-sm" data-copy-text="{{ $seed_phrase }}"><i class="far fa-copy"></i></button>
            </p>

            <p><a href="#newAddress" class="btn btn-primary" data-bs-toggle="collapse">Generate New Address</a></p>
        </div>

        <div id="newAddress" class="mb-5 collapse">
            <h3>New Address:</h3>

            <p class="mb-5">
                {{ $address }}
                <button class="btn btn-link btn-sm" data-copy-text="{{ $address }}"><i class="far fa-copy"></i></button>
            </p>

            <p><a href="{{ route('addresses.index') }}?show_data=1">Go back to Manage Addresses</a></p>
        </div>

    @endif

@endsection
