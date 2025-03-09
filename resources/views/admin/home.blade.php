@extends('admin.layouts.admin')

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
    <h5>Welcome to your Admin Dashboard</h5>
    <p>Here you can manage your dashboard items.</p>
@endsection
