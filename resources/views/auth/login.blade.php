@extends('layouts.app')

@section('auth-content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-logo">
            <div style="font-size:2rem;color:#8b5cf6;">&#10022;</div>
            <h1>AI Builder</h1>
            <p>Sign in to your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" name="email" class="form-input" value="admin@ai-builder.com" required autofocus>
                @error('email')<p style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input id="password" type="password" name="password" class="form-input" value="password" required>
                @error('password')<p style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</p>@enderror
            </div>

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
                <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.85rem;color:#94a3b8;cursor:pointer;">
                    <input type="checkbox" name="remember" checked style="accent-color:#3b82f6;">
                    <span>Remember me</span>
                </label>
                <a href="#" style="font-size:0.85rem;color:#3b82f6;">Forgot password?</a>
            </div>

            <button type="submit" class="btn btn-primary w-full" style="justify-content:center;padding:0.75rem;font-size:0.9rem;">
                Sign In
            </button>

            <div class="auth-hint">
                Demo: <span style="color:#3b82f6;font-family:'Fira Code',monospace;">admin@ai-builder.com</span> / <span style="color:#3b82f6;font-family:'Fira Code',monospace;">password</span>
            </div>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="{{ route('register') }}" style="color:#3b82f6;">Sign up</a>
        </div>
    </div>
</div>
@overwrite