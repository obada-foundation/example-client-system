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

@section('extra_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Accounts</a></li>
@endsection


@section('page_content')

    @if($step == 1)

        <div class="mb-5">
            <h3>New Seed Phrase:</h3>
            <p>
                <strong>{{ $seed_phrase }}</strong>
                <button class="btn btn-link btn-sm" data-copy-text="{{ $seed_phrase }}"><i class="far fa-copy"></i></button>
            </p>
            <div class="alert alert-warning" style="max-width: 550px;">
                <small><i class="fas fa-exclamation-triangle me-1"></i></small> <strong>Save this phrase somewhere
                    safe</strong>
                <br>
                Anyone who knows your seed phrase can control all of your assets.
                <br>
                If you lose the seed phrase, you will lose access, and it can't be recovered.
            </div>
            <p><a href="{{ route('accounts.generate-phrase') }}?step=2" class="btn btn-primary">I saved the seed phrase</a></p>
        </div>

    @elseif($step == 2)

        <div class="mb-5">
            <h3>Enter two words from the new phrase to confirm:</h3>
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <form method="POST" action="{{ route('accounts.save-phrase') }}" class="row">
                        @csrf

                        <div class="col-12 col-sm-4">
                            <div class="mb-2">
                                <input type="text" id="word2" class="form-control" name="word2" placeholder="Enter 2nd word" required>
                                @if ($errors->has('word2'))
                                    <span class="form-helper text-danger">{{ $errors->first('word2') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="mb-3">
                                <input type="text" id="word7" class="form-control" name="word7" placeholder="Enter 7th word" required>
                                @if ($errors->has('word7'))
                                    <span class="form-helper text-danger">{{ $errors->first('word7') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endif

@endsection
