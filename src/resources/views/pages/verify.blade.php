@extends('layouts.app-with-nav',[
    'page_title'        => 'Verify a Document',
    'hide_breadcrumbs'  => true,
    'hide_h1'           => true
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

    <div class="w-md-50 text-center mx-auto">
        <h1 class="mb-5">Verify a Document</h1>

        @if($verified == '1')

            <div class="mb-3 alert alert-success d-flex align-items-center justify-content-center">
                <i class="fas fa-check-circle text-success fs-2 me-2"></i>
                <div>Document Verified!</div>
            </div>

            <div class="mt-4">
                <a href="{{ route('verify') }}" class="btn btn-primary btn-lg">Verify Another Document</a>
            </div>

        @else
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
                        <div class="dz-default dz-message">
                            <i class="fas fa-file-upload d-block fs-1 mb-3" style="color: #dddddd;"></i>
                            <button class="dz-button" type="button"><strong>Choose a file</strong> or drag it here</button>
                        </div>
                    </div>
                </div>

                <div class="mb-3 alert alert-danger d-flex align-items-center justify-content-center">
                    <i class="fas fa-times-circle text-danger fs-2 me-2"></i>
                    <div>Verification Failed!</div>
                </div>

                <div class="mb-3 alert alert-success d-flex align-items-center justify-content-center">
                    <i class="fas fa-check-circle text-success fs-2 me-2"></i>
                    <div>Document Verified!</div>
                </div>

                <div class="mt-4">
    {{--                <button class="btn btn-primary btn-lg" onclick="return false;">Verify</button>--}}
                    <a href="{{ route('timestamp-certificate') }}" class="btn btn-primary btn-lg">Verify</a>
                </div>
            </form>
        @endif
    </div>

@endsection
