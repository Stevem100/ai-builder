@extends('layouts.app')
@section('page-title', 'Notifications')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
    <div>
        <h2 style="font-size:1.25rem;font-weight:700;">Notifications</h2>
        <p style="font-size:0.85rem;color:#64748b;">{{ $unreadCount }} unread</p>
    </div>
    <form method="POST" action="#" onsubmit="markAllRead();return false;">
        <button type="submit" class="btn btn-ghost btn-sm">Mark All as Read</button>
    </form>
</div>

<div class="card" style="padding:0;">
    @foreach($notifications as $n)
    <div class="notif-item {{ !$n->read ? 'unread' : '' }}" onclick="markRead({{ $n->id }}, this)">
        <div class="notif-icon" style="background:{{ $n->type === 'success' ? 'rgba(16,185,129,0.12)' : ($n->type === 'error' ? 'rgba(239,68,68,0.12)' : ($n->type === 'warning' ? 'rgba(245,158,11,0.12)' : 'rgba(59,130,246,0.12)')) }};color:{{ $n->type === 'success' ? '#10b981' : ($n->type === 'error' ? '#ef4444' : ($n->type === 'warning' ? '#f59e0b' : '#3b82f6')) }};">
            @if($n->type === 'success')
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
            @elseif($n->type === 'error')
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            @elseif($n->type === 'warning')
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
            @else
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
            @endif
        </div>
        <div style="flex:1;min-width:0;">
            <div style="font-size:0.85rem;font-weight:{{ $n->read ? '400' : '600' }};color:#e2e8f0;">{{ $n->title }}</div>
            <div style="font-size:0.8rem;color:#94a3b8;margin-top:2px;" class="line-clamp-2">{{ $n->message }}</div>
            <div style="font-size:0.7rem;color:#64748b;margin-top:4px;">{{ $n->created_at->diffForHumans() }}</div>
        </div>
    </div>
    @endforeach
</div>

@push('scripts')
<script>
function markRead(id, el) {
    el.classList.remove('unread');
    fetch('/api/notifications/' + id + '/read', {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}
    });
}
function markAllRead() {
    document.querySelectorAll('.notif-item.unread').forEach(el => el.classList.remove('unread'));
}
</script>
@endpush
@endsection