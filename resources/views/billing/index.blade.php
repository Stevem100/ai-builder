@extends('layouts.app')
@section('page-title', 'Billing')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
    <div>
        <h2 style="font-size:1.25rem;font-weight:700;">Billing & Usage</h2>
        <p style="font-size:0.85rem;color:#64748b;">Current plan: <span style="color:#e2e8f0;font-weight:600;">{{ ucfirst($subscription->plan) }}</span></p>
    </div>
    <a href="{{ route('billing.plans') }}" class="btn btn-primary btn-sm">Change Plan</a>
</div>

{{-- Current plan card --}}
<div class="card mb-6" style="border-color:#3b82f6;background:linear-gradient(135deg,rgba(59,130,246,0.05),rgba(139,92,246,0.05));">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
        <div>
            <div style="font-size:0.75rem;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;">Current Plan</div>
            <div style="font-size:1.5rem;font-weight:700;margin-top:0.25rem;">{{ ucfirst($subscription->plan) }} Plan</div>
            <div style="font-size:0.85rem;color:#94a3b8;">{{ $subscription->plan === 'free' ? '$0/month' : ($subscription->plan === 'pro' ? '$29/month' : '$99/month') }} &middot; Renews {{ $subscription->current_period_end?->diffForHumans() }}</div>
        </div>
        <span class="badge badge-green" style="font-size:0.8rem;padding:0.375rem 0.75rem;">Active</span>
    </div>
</div>

{{-- Usage meters --}}
<h3 style="font-size:1rem;font-weight:600;margin-bottom:1rem;">Usage</h3>
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;margin-bottom:2rem;" class="grid grid-cols-1 sm:grid-cols-2">
    @foreach($usage as $key => $u)
    <div class="card">
        <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;">
            <span style="font-size:0.85rem;color:#94a3b8;">{{ ucfirst(str_replace('_',' ',$key)) }}</span>
            <span style="font-size:0.85rem;font-weight:600;">
                @if($key === 'storage')
                    {{ $u['used'] }} GB / {{ $u['limit'] }} GB
                @elseif($key === 'ai_tokens')
                    {{ number_format($u['used']) }} / {{ number_format($u['limit']) }}
                @else
                    {{ $u['used'] }} / {{ $u['limit'] }}
                @endif
            </span>
        </div>
        <div class="progress-bar">
            @php $pct = min(100, ($u['used'] / max($u['limit'],1)) * 100); @endphp
            <div class="progress-fill" style="width:{{ $pct }}%;background:{{ $pct > 80 ? '#ef4444' : ($pct > 60 ? '#f59e0b' : '#3b82f6') }};"></div>
        </div>
    </div>
    @endforeach
</div>

{{-- Invoices --}}
<h3 style="font-size:1rem;font-weight:600;margin-bottom:1rem;">Recent Invoices</h3>
<div class="card" style="padding:0;overflow-x:auto;">
    <table class="data-table">
        <thead><tr><th>Invoice</th><th>Date</th><th>Amount</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($invoices as $inv)
        <tr>
            <td style="font-family:'Fira Code',monospace;font-size:0.85rem;">{{ $inv['id'] }}</td>
            <td>{{ $inv['date'] }}</td>
            <td style="font-weight:500;">${{ number_format($inv['amount'], 2) }}</td>
            <td><span class="badge badge-green">{{ ucfirst($inv['status']) }}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection