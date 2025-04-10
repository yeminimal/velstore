@extends('themes.xylo.layouts.master')  

@section('content')
    <h2>Customer Register</h2>

    <form method="POST" action="{{ route('customer.register') }}">
        @csrf

        <div>
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password" required>
            @error('password') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account?
        <a href="{{ route('customer.login') }}">Login here</a>
    </p>
@endsection
