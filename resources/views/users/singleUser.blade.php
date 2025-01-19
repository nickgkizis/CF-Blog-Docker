@extends('layouts.app')

@section('title', 'Main Page')

@section('content')
<link rel="stylesheet" href="{{ asset('styles/users/Users.blade.css') }}">
<div class="container my-5">
    <h2 class="text-center mb-4">User Profile</h2>

    @if ($user)
        <div class="card shadow-sm">
            <div class="card-body">
                <p><strong>ID:</strong> {{ $user->id }}</p>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
            </div>
        </div>
    @else
        <p class="text-center text-danger">User not found.</p>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('users.index') }}" class="btn btn-primary">Back to All Users</a>
    </div>
</div>
@endsection
