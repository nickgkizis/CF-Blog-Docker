@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="login-container d-flex justify-content-center align-items-center">
    <div class="login-card">
        <h1 class="login-title text-center mb-4">Login</h1>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" required class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" required class="form-control">
            </div>

            <button type="submit" class="btn login-button w-100 mt-3">Login</button>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger mt-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>

    /* Card Design */
    .login-card {
        width: 100%;
        max-width: 400px;
        padding: 2em;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Form Title */
    .login-title {
        font-size: 2rem;
        color: #333;
    }

    /* Button styling */
    .login-button {
        font-weight: bold;
        color: #fff;
        background: #5f9e9e;
        border: none;
        transition: background 0.3s ease;
    }

    .login-button:hover {
        background: #4a7f7f;
    }
</style>
@endsection
