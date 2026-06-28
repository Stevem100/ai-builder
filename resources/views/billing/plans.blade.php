@extends('layouts.app')
@section('page-title', 'Pricing Plans')
@section('content')
<div style="text-align:center;margin-bottom:2rem;">
    <h2 style="font-size:1.5rem;font-weight:700;">Choose Your Plan</h2>
    <p style="color:#64748b;font-size:0.9rem;margin-top:0.5rem;">Scale your projects with the right plan</p>
</div>

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;max-width:900px;margin:0 auto;" class="grid grid-cols-1 md:grid-cols-3">

    {{-- Free --}}
    <div class="plan-card">
        <div style="font-size:0.85rem;font-weight:600;color:#94a3b8;">Free</div>
        <div style="font-size:2.5rem;font-weight:800;margin:0.5rem 0;">$0</div>
        <div style="font-size:0.8rem;color:#64748b;margin-bottom:1.25rem;">/month</div>
        <div style="flex:1;display:flex;flex-direction:column;gap:0.375rem;">
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>3 Projects</div>
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>50 Deployments/mo</div>
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>5 GB Storage</div>
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>10K AI Tokens</div>
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>Community Support</div>
        </div>
        <form method="POST" action="{{ route('billing.subscribe') }}" style="margin-top:1.5rem;">
            @csrf
            <input type="hidden" name="plan" value="free">
            <button type="submit" class="btn {{ $subscription->plan === 'free' ? 'btn-ghost' : 'btn-primary' }} w-full" style="justify-content:center;" {{ $subscription->plan === 'free' ? 'disabled' : '' }}>
                {{ $subscription->plan === 'free' ? 'Current Plan' : 'Downgrade' }}
            </button>
        </form>
    </div>

    {{-- Pro --}}
    <div class="plan-card featured">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div style="font-size:0.85rem;font-weight:600;color:#3b82f6;">Pro</div>
            <span class="badge badge-blue" style="font-size:0.65rem;">POPULAR</span>
        </div>
        <div style="font-size:2.5rem;font-weight:800;margin:0.5rem 0;">$29</div>
        <div style="font-size:0.8rem;color:#64748b;margin-bottom:1.25rem;">/month</div>
        <div style="flex:1;display:flex;flex-direction:column;gap:0.375rem;">
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>25 Projects</div>
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>200 Deployments/mo</div>
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>25 GB Storage</div>
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>100K AI Tokens</div>
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>Custom Domains</div>
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>Priority Support</div>
        </div>
        <form method="POST" action="{{ route('billing.subscribe') }}" style="margin-top:1.5rem;">
            @csrf
            <input type="hidden" name="plan" value="pro">
            <button type="submit" class="btn {{ $subscription->plan === 'pro' ? 'btn-ghost' : 'btn-primary' }} w-full" style="justify-content:center;">
                {{ $subscription->plan === 'pro' ? 'Current Plan' : 'Upgrade to Pro' }}
            </button>
        </form>
    </div>

    {{-- Enterprise --}}
    <div class="plan-card">
        <div style="font-size:0.85rem;font-weight:600;color:#f59e0b;">Enterprise</div>
        <div style="font-size:2.5rem;font-weight:800;margin:0.5rem 0;">$99</div>
        <div style="font-size:0.8rem;color:#64748b;margin-bottom:1.25rem;">/month</div>
        <div style="flex:1;display:flex;flex-direction:column;gap:0.375rem;">
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>Unlimited Projects</div>
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>Unlimited Deployments</div>
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>100 GB Storage</div>
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>1M AI Tokens</div>
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>SSO & SAML</div>
            <div class="plan-feature"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>Dedicated Support</div>
        </div>
        <form method="POST" action="{{ route('billing.subscribe') }}" style="margin-top:1.5rem;">
            @csrf
            <input type="hidden" name="plan" value="enterprise">
            <button type="submit" class="btn {{ $subscription->plan === 'enterprise' ? 'btn-ghost' : 'btn-primary' }} w-full" style="justify-content:center;">
                {{ $subscription->plan === 'enterprise' ? 'Current Plan' : 'Go Enterprise' }}
            </button>
        </form>
    </div>
</div>
@endsection