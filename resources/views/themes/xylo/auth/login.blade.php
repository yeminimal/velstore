@extends('themes.xylo.layouts.master')  

@section('content')
    <h2>Customer Login</h2>

    <form method="POST" action="{{ route('customer.login') }}">
        @csrf

        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <label>
            <input type="checkbox" name="remember"> Remember Me
        </label>

        <button type="submit">Login</button>
    </form>

    <a href="{{ route('customer.password.request') }}">Forgot Password?</a>
@endsection
