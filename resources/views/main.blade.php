@extends('layouts.app')

@section('title', 'Main Page')

@section('content')
<link rel="stylesheet" href="{{ asset('styles/main.blade.css') }}">
    <div class="outer text-center mb-5">
        @if(session('message'))
            <div class="alert alert-success text-center">
                {{ session('message') }}
            </div>
        @endif

        <div class="list-group shadow-lg d-flex align-items-center">
            <a href="{{ route('articles.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                <i class="fas fa-book-open fa-2x me-3 text-danger"></i>
                <div class="d-flex flex-column  align-items-start text-start">
                    <h4 class="mb-1">All Articles</h4>
                    <p class="mb-0">View all available articles</p>
                </div>
            </a>
            <a href="{{ route('articles.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                <i class="fas fa-pencil-alt fa-2x me-3 text-secondary"></i>
                <div class="d-flex flex-column  align-items-start text-start">
                    <h4 class="mb-1">Create Article</h4>
                    <p class="mb-0">Publish your articles</p>
                </div>
            </a>
            <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                <i class="fas fa-users fa-2x me-3 text-primary"></i>
                <div class="d-flex flex-column  align-items-start text-start">
                    <h4 class="mb-1">User Management</h4>
                    <p class="mb-0">Manage users</p>
                </div>
            </a>
            <a href="{{ route('register') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                <i class="fas fa-user-plus fa-2x me-3 text-success"></i>
                <div class="d-flex flex-column  align-items-start text-start">
                    <h4 class="mb-1">Register</h4>
                    <p class="mb-0">Create a new account</p>
                </div>
            </a>
            <a href="{{ route('login') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                <i class="fas fa-key fa-2x me-3 text-warning"></i>
                <div class="d-flex flex-column  align-items-start text-start">
                    <h4 class="mb-1">Login</h4>
                    <p class="mb-0">Login to your account</p>
                </div>
            </a>
            
        </div>
    </div>
@endsection