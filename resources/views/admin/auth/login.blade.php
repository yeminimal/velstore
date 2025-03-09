@extends('admin.layouts.login')

@section('css')
<style>
    body {
        background-color: #f4f7f6;
        color: #333333;
    }
    .login-container {
        max-width: 400px;
        margin: 50px auto;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .form-control:focus {
        border-color: #66b3ff;
        box-shadow: 0 0 0 0.2rem rgba(102, 179, 255, 0.25);
    }
    .btn-primary {
        background-color: #66b3ff;
        border-color: #66b3ff;
    }
    .btn-primary:hover {
        background-color: #559fdc;
        border-color: #559fdc;
    }
</style>
@endsection

@section('content')
    <div class="login-container">
        <div class="text-center mb-4">
            <h1>Martix</h1>
        </div>
        <h2 class="text-center mb-4">{{ cms_translate('auth.login') }}</h2>
        @error('password')
            <div id="errorBar" class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror
        @error('email')
            <div id="errorBar" class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">{{ cms_translate('auth.email') }}</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="email" placeholder="{{ cms_translate('auth.email') }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">{{ cms_translate('auth.password') }}</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="{{ cms_translate('auth.password') }}" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">{{ cms_translate('auth.remember_me') }}</label>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">{{ cms_translate('auth.login') }}</button>
            </div>
        </form>
    </div>
@endsection

