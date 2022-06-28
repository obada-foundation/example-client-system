@extends('layouts.app')

@section('head')
    <title>Register User</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection

@section('content')
    @include('common.nav',['fixed'=>false])

    <div class="main">
        <div class="container-lg">
            <div class="d-flex justify-content-center">
                <div class="card" style="max-width: 100%; width: 350px;">
                    <h3 class="card-header text-center">Blockchain Testnet Register</h3>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register.user') }}">
                            @csrf

                            <p class="text-danger text-center mb-4" style="line-height: 1.2;">
                                This registration is for the self-contained blockchain demo site, only. All test data entered here may be deleted at any time during the blockchain Testnet development phase.
                            </p>

                            <div class="mt-2 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" class="form-control @if ($errors->has('name')) is-invalid @endif" name="name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" id="email" class="form-control @if ($errors->has('email')) is-invalid @endif" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" class="form-control @if ($errors->has('password')) is-invalid @endif" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" id="password_confirmation" class="form-control @if ($errors->has('password_confirmation')) is-invalid @endif" name="password_confirmation" required>
                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>

                            <div class="mt-5 mb-3">
                                <button type="submit" class="btn btn-dark w-100">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('common.footer')
@endsection

@section('scripts')
    <script src="{{ mix('/js/base.js') }}"></script>
@endsection
