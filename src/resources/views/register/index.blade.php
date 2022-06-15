@extends('layouts.app', ['body_class' => 'landing-page'])

@section('head')
    <title>Register User</title>
    <meta name="description" content="__description__">
    <meta name="keywords" content="__keywords__">
@endsection

@section('content')
    <div class="main">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="card" style="max-width: 100%; width: 300px;">
                    <h3 class="card-header text-center">Register User</h3>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register.user') }}">
                            @csrf

                            <div class="form-outline mt-2 mb-4">
                                <input type="text" id="name" class="form-control form-control-lg" name="name" value="{{ old('name') }}" required autofocus>
                                <label for="name" class="form-label">Name</label>
                                @if ($errors->has('name'))
                                    <span class="form-helper text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-outline mb-4">
                                <input type="text" id="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" required>
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

                            <div class="form-outline mb-4">
                                <input type="password" id="password_confirmation" class="form-control form-control-lg" name="password_confirmation" required>
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                @if ($errors->has('password_confirmation'))
                                    <span class="form-helper text-danger">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>

                            <div class="mt-5 mb-3">
                                <button type="submit" class="btn btn-dark btn-block">Sign Up</button>
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
