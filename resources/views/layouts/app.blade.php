<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — AI Builder</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col">

{{-- Auth pages: no sidebar --}}
@yield('auth-content')

{{-- Main app layout with sidebar --}}
@section('app-layout')
<div class="flex min-h-screen">

    {{-- Mobile overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
        <div style="padding:1.25rem 1rem;border-bottom:1px solid #1e293b;">
            <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:0.5rem;text-decoration:none;">
                <span style="font-size:1.5rem;color:#8b5cf6;">&#10022;</span>
                <span style="font-size:1.125rem;font-weight:700;color:#e2e8f0;">AI Builder</span>
            </a>
        </div>

        <nav style="flex:1;padding:0.5rem 0;overflow-y:auto;">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Dashboard
            </a>
            <a href="{{ route('projects.index') }}" class="nav-item {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>
                Projects
            </a>
            <a href="{{ route('deployments.index') }}" class="nav-item {{ request()->routeIs('deployments.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/></svg>
                Deployments
            </a>
            <a href="{{ route('domains.index') }}" class="nav-item {{ request()->routeIs('domains.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                Domains
            </a>
            <a href="{{ route('billing.index') }}" class="nav-item {{ request()->routeIs('billing.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                Billing
            </a>
            <a href="{{ route('notifications.index') }}" class="nav-item {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                Notifications
                @if($unreadCount ?? 0 > 0)
                <span style="margin-left:auto;background:#ef4444;color:white;font-size:0.65rem;padding:1px 6px;border-radius:9999px;font-weight:600;">{{ $unreadCount }}</span>
                @endif
            </a>
            <a href="{{ route('settings.index') }}" class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                Settings
            </a>
        </nav>

        {{-- User info --}}
        <div style="padding:0.75rem 1rem;border-top:1px solid #1e293b;display:flex;align-items:center;gap:0.625rem;">
            <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#8b5cf6);display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:600;color:white;">
                {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 1)) : 'A' }}
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:0.8rem;font-weight:500;color:#e2e8f0;" class="truncate">{{ Auth::check() ? Auth::user()->name : 'Admin User' }}</div>
                <div style="font-size:0.7rem;color:#64748b;">{{ Auth::check() ? ucfirst(Auth::user()->role ?? 'admin') : 'Admin' }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;cursor:pointer;color:#64748b;padding:4px;" title="Logout">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main content --}}
    <div class="flex flex-col flex-1" style="margin-left:260px;">
        {{-- Top header --}}
        <header style="height:56px;border-bottom:1px solid #1e293b;display:flex;align-items:center;padding:0 1.5rem;gap:1rem;background:#0a0a0f;position:sticky;top:0;z-index:30;">
            <button class="hidden max-[768px]:flex" onclick="toggleSidebar()" style="background:none;border:none;cursor:pointer;color:#94a3b8;padding:4px;" id="menuBtn">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <h1 style="font-size:1rem;font-weight:600;">@yield('page-title', 'Dashboard')</h1>
            <div style="flex:1;"></div>
            <div style="position:relative;" class="hidden md:block">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" style="position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" placeholder="Search..." style="background:#12121a;border:1px solid #1e293b;border-radius:0.5rem;padding:0.375rem 0.75rem 0.375rem 2.25rem;color:#e2e8f0;font-size:0.8rem;width:220px;outline:none;">
            </div>
            <a href="{{ route('notifications.index') }}" style="position:relative;color:#94a3b8;" class="relative">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                @if($unreadCount ?? 0 > 0)
                <span style="position:absolute;top:-4px;right:-4px;background:#ef4444;color:white;font-size:0.6rem;width:16px;height:16px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:600;">{{ $unreadCount }}</span>
                @endif
            </a>
        </header>

        {{-- Page content --}}
        <main style="flex:1;padding:1.5rem;overflow-y:auto;" class="animate-fade-in">
            @if(session('success'))
            <div style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);border-radius:0.5rem;padding:0.75rem 1rem;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
                <span style="font-size:0.85rem;color:#34d399;">{{ session('success') }}</span>
            </div>
            @endif
            @if(session('error'))
            <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:0.5rem;padding:0.75rem 1rem;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                <span style="font-size:0.85rem;color:#f87171;">{{ session('error') }}</span>
            </div>
            @endif
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer style="padding:0.75rem 1.5rem;border-top:1px solid #1e293b;text-align:center;font-size:0.75rem;color:#64748b;">
            &copy; 2026 AI Builder Platform. All rights reserved.
        </footer>
    </div>
</div>
@endsection

<script>
function toggleSidebar() {
    const s = document.getElementById('sidebar');
    const o = document.getElementById('sidebarOverlay');
    s.style.transform = s.style.transform === 'translateX(-100%)' ? 'translateX(0)' : 'translateX(-100%)';
    o.style.display = s.style.transform === 'translateX(-100%)' ? 'none' : 'block';
}

// Responsive: collapse sidebar on mobile
if (window.innerWidth < 768) {
    document.getElementById('sidebar').style.transform = 'translateX(-100%)';
}
window.addEventListener('resize', () => {
    const s = document.getElementById('sidebar');
    if (window.innerWidth >= 768) {
        s.style.transform = 'translateX(0)';
        document.getElementById('sidebarOverlay').style.display = 'none';
    } else {
        s.style.transform = 'translateX(-100%)';
    }
});
</script>
@stack('scripts')
</body>
</html>