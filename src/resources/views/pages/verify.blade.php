@extends('layouts.app-with-nav',[
    'page_title'=>'Verify a Document'
])


@section('head')
    <title>Verify a Document</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">

    <link rel="stylesheet" type="text/css" href="{{ mix('/css/verify_index.css') }}"/>
@endsection


@section('scripts')
    <script src="{{ mix('/js/verify_index.js') }}"></script>
@endsection


@section('page_content')

    <div class="row">
        <div class="col-12 col-sm-9 col-md-6">
            <form id="verify_form" method="POST" action="">
                @csrf

                <div class="mb-3">
                    <input type="text" id="seed_phrase" class="form-control" name="seed_phrase" placeholder="Enter USN" required>
                    @if ($errors->has('usn'))
                        <span class="form-helper text-danger">{{ $errors->first('usn') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <div id="verify-form-field" class="dropzone">
                        <div class="dz-default dz-message"><button class="dz-button" type="button"><strong>Choose a file</strong> or drag it here</button></div>
                    </div>
                </div>

                <button class="btn btn-primary" onclick="showAlert();return false;">Verify</button>
            </form>
        </div>
    </div>

@endsection
