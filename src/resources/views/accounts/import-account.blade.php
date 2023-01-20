@extends('layouts.app-with-nav',[
    'page_title'=>'Import Account',
])


@section('head')
    <title>Import Account</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection


@section('scripts')
    <script src="{{ mix('/js/base.js') }}"></script>
@endsection


@section('extra_breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('accounts.manage') }}">Manage Seed Phrase</a></li>
@endsection


@section('page_content')

    <section class="mb-5">
{{--        <h3>Import existing key:</h3>--}}

        <div class="row">
            <div class="col-12 col-sm-9 col-md-8">
                <form action="{{ route('accounts.import-account-post') }}" method="POST" enctype="multipart/form-data"
                      class="row">
                    @csrf

                    <div class="col-12 col-sm-4">
                        <div class="mb-2">
                            <select id="key_type" class="form-select" name="key_type" required>
                                <option value="">Choose key type</option>
                                <option value="1">Private Key</option>
                                <option value="2" disabled>Admin Key</option>
                                <option value="3" disabled>Read-Only Key</option>
                            </select>
                            @if ($errors->has('key_type'))
                                <span class="form-helper text-danger">{{ $errors->first('key_type') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 col-sm-5">
                        <div class="mb-3">
                            <input type="file" id="key_value" class="form-control" name="key_value"
                                   placeholder="Enter Key" required>
                            @if ($errors->has('key_value'))
                                <span class="form-helper text-danger">{{ $errors->first('key_value') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <button type="submit" class="btn btn-primary">Proceed</button>
                    </div>
                </form>
            </div>

            <div class="col-12 col-sm-3 col-md-4">
                <div class="mt-2 mt-sm-0">Import a single address, not controlled by the seed phrase here.</div>
            </div>
        </div>
    </section>

@endsection
