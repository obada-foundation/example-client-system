@extends('layouts.app', ['body_class' => 'landing-page'])

@section('head')
    <title>Login</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection

@section('content')
    @include('common.nav',['fixed'=>false])

    <div class="main">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="card" style="max-width: 100%; width: 350px;">
                    <h3 class="card-header text-center">Blockchain Testnet Login</h3>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login.auth') }}">
                            @csrf

                            <p class="text-danger text-center mb-4" style="line-height: 1.2;">
                                You are logging in to the blockchain demo site, for testing purposes only. Your login information does not work anywhere else. All test data entered here may be deleted at any time during the OBADA blockchain Testnet development phase.
                            </p>

                            <div class="mt-2 mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="form-helper text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="form-helper text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="d-flex justify-content-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} value="on">
                                    <label class="form-check-label" for="remember">Remember Me</label>
                                </div>
                            </div>

                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-dark btn-lg w-100">Sign In</button>
                            </div>

                            <div class="mt-3 text-center">
                                <p><small>Don't have an account? <a href="{{ route('register.index') }}">Sign Up</a>.</small></p>
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
@endsection
