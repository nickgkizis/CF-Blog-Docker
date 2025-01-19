@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="register-container d-flex justify-content-center align-items-center">
    <div class="register-card">
        <h1 class="register-title text-center mb-4">Register</h1>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" required class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" required class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" required class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="form-control">
            </div>

            <button type="submit" class="btn register-button w-100 mt-3">Register</button>
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
    /* Register Card Styling */
    .register-card {
        width: 100%;
        max-width: 400px;
        padding: 2em;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Register Title */
    .register-title {
        font-size: 2rem;
        color: #333;
    }

    /* Register Button Styling */
    .register-button {
        font-weight: bold;
        color: #fff;
        background: #5f9e9e;
        border: none;
        transition: background 0.3s ease;
    }

    .register-button:hover {
        background: #4a7f7f;
    }
</style>
@endsection
