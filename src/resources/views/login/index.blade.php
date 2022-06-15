@extends('layouts.app', ['body_class' => 'landing-page'])

@section('head')
    <title>Login</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection

@section('content')
    <div class="main">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="card" style="max-width: 100%; width: 300px;">
                    <h3 class="card-header text-center">Login</h3>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login.auth') }}">
                            @csrf

                            <div class="form-outline mt-2 mb-4">
                                <input id="email" name="email" type="email" class="form-control form-control-lg" value="{{ old('email') }}" required autofocus>
                                <label for="email" class="form-label">Email</label>
                                @if ($errors->has('email'))
                                    <span class="form-helper text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="password" class="form-control form-control-lg" name="password" required>
                                <label for="password" class="form-label">Password</label>
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

                            <div class="mb-3">
                                <button type="submit" class="btn btn-dark btn-block">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
