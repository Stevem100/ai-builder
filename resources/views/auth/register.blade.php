@extends('layouts.app')

@section('auth-content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-logo">
            <div style="font-size:2rem;color:#8b5cf6;">&#10022;</div>
            <h1>AI Builder</h1>
            <p>Create your account</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Name</label>
                <input id="name" type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                @error('name')<p style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="you@example.com" required>
                @error('email')<p style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input id="password" type="password" name="password" class="form-input" placeholder="Min. 8 characters" required>
                @error('password')<p style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" placeholder="Repeat password" required>
            </div>

            <button type="submit" class="btn btn-primary w-full" style="justify-content:center;padding:0.75rem;font-size:0.9rem;">
                Create Account
            </button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="{{ route('login') }}" style="color:#3b82f6;">Sign in</a>
        </div>
    </div>
</div>
@overwrite