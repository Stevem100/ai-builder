@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;" class="grid grid-cols-2 lg:grid-cols-4">
    <div class="card stat-card">
        <div class="stat-icon" style="background:rgba(59,130,246,0.12);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>
        </div>
        <div><div class="stat-value">{{ $projectCount }}</div><div class="stat-label">Total Projects</div><div class="stat-trend up">&#8593; 12% this month</div></div>
    </div>
    <div class="card stat-card">
        <div class="stat-icon" style="background:rgba(16,185,129,0.12);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/></svg>
        </div>
        <div><div class="stat-value">{{ $activeDeployments }}</div><div class="stat-label">Active Deployments</div><div class="stat-trend up">&#8593; 3 this week</div></div>
    </div>
    <div class="card stat-card">
        <div class="stat-icon" style="background:rgba(139,92,246,0.12);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
        </div>
        <div><div class="stat-value">{{ number_format($aiTokensUsed / 1000, 1) }}K</div><div class="stat-label">AI Tokens Used</div><div class="stat-trend down">&#8595; 5% vs last week</div></div>
    </div>
    <div class="card stat-card">
        <div class="stat-icon" style="background:rgba(16,185,129,0.12);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
        <div><div class="stat-value">99.9%</div><div class="stat-label">System Uptime</div><div class="stat-trend up">&#8593; 0.2% this month</div></div>
    </div>
</div>

{{-- Two column --}}
<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;margin-bottom:1.5rem;" class="grid grid-cols-1 lg:grid-cols-3">

    {{-- Left: Chat + Activity --}}
    <div style="grid-column:span 2;" class="flex flex-col gap-4">
        {{-- AI Chat --}}
        <div class="card" style="padding:0;">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid #1e293b;display:flex;align-items:center;gap:0.5rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg>
                <span style="font-weight:600;font-size:0.9rem;">AI Chat Assistant</span>
                <span class="badge badge-purple" style="margin-left:auto;">Online</span>
            </div>
            <div class="chat-messages" id="chatMessages">
                <div class="chat-msg user">
                    <div class="msg-avatar">U</div>
                    <div class="msg-bubble">Create an e-commerce website with product catalog and cart</div>
                </div>
                <div class="chat-msg assistant">
                    <div class="msg-avatar">&#10022;</div>
                    <div class="msg-bubble">I'll help you build that! Here's a plan:<br><br>1) Set up project with TypeScript<br>2) Create product models<br>3) Build catalog page with filtering<br>4) Implement cart with state management<br>5) Add checkout with Stripe<br><br>Shall I start generating the code?</div>
                </div>
                <div class="chat-msg user">
                    <div class="msg-avatar">U</div>
                    <div class="msg-bubble">Yes, let's start with the product catalog page</div>
                </div>
            </div>
            <div class="chat-input-area">
                <input type="text" id="chatInput" placeholder="Ask AI to generate code..." onkeydown="if(event.key==='Enter')sendChat()">
                <button class="btn btn-primary btn-sm" onclick="sendChat()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></svg>
                    Send
                </button>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="card">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.75rem;">
                <span style="font-weight:600;font-size:0.9rem;">Recent Activity</span>
                <a href="#" style="font-size:0.8rem;color:#64748b;">View all</a>
            </div>
            @forelse($recentActivity as $activity)
            <div class="activity-item">
                <div class="activity-icon green">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
                </div>
                <div>
                    <div class="activity-text">{{ $activity->description }}</div>
                    <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:2rem;color:#64748b;font-size:0.85rem;">No recent activity</div>
            @endforelse
        </div>
    </div>

    {{-- Right: Health + Quick Actions --}}
    <div class="flex flex-col gap-4">
        <div class="card">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.75rem;">
                <span style="font-weight:600;font-size:0.9rem;">System Health</span>
                <span class="badge badge-green">All Systems Go</span>
            </div>
            @foreach(['API Server','Database','Redis Cache','Containers','AI Engine'] as $service)
            <div class="health-item">
                <div class="health-label"><div class="health-dot online"></div>{{ $service }}</div>
                <div class="health-status">Online</div>
            </div>
            @endforeach
        </div>

        <div class="card">
            <div style="font-weight:600;font-size:0.9rem;margin-bottom:0.75rem;">Quick Actions</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;">
                <button class="quick-btn" onclick="location.href='{{ route('projects.create') }}'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
                    New Project
                </button>
                <button class="quick-btn" onclick="location.href='{{ route('deployments.index') }}'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/></svg>
                    Deployments
                </button>
                <button class="quick-btn" onclick="location.href='{{ route('notifications.index') }}'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    Notifications
                </button>
                <button class="quick-btn" onclick="document.getElementById('chatInput').focus()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/></svg>
                    AI Chat
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Deployment Pipeline --}}
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
        <span style="font-weight:600;font-size:0.9rem;">Deployment Pipeline</span>
        <span class="badge badge-blue">In Progress</span>
    </div>
    <div class="pipeline">
        @foreach(['Generate','Install Deps','Run Tests','Build Image','Deploy','Domain','SSL & Live','Monitor'] as $i => $step)
        @if($i > 0)<div class="pipeline-connector {{ $i < 5 ? 'completed' : '' }}"></div>@endif
        <div class="pipeline-step {{ $i < 4 ? 'completed' : ($i === 4 ? 'current' : '') }}">
            <div class="step-dot">
                @if($i < 4)
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6 9 17l-5-5"/></svg>
                @else
                {{ $i + 1 }}
                @endif
            </div>
            <span>{{ $step }}</span>
        </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
function sendChat() {
    const input = document.getElementById('chatInput');
    const msg = input.value.trim();
    if (!msg) return;
    const container = document.getElementById('chatMessages');
    container.innerHTML += '<div class="chat-msg user"><div class="msg-avatar">U</div><div class="msg-bubble">' + msg.replace(/</g,'&lt;').replace(/>/g,'&gt;') + '</div></div>';
    input.value = '';
    container.scrollTop = container.scrollHeight;

    fetch('{{ route("api.ai.chat") }}', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
        body: JSON.stringify({message: msg})
    })
    .then(r => r.json())
    .then(data => {
        const resp = data.message.replace(/\n/g,'<br>');
        container.innerHTML += '<div class="chat-msg assistant"><div class="msg-avatar">&#10022;</div><div class="msg-bubble">' + resp + '</div></div>';
        container.scrollTop = container.scrollHeight;
    })
    .catch(() => {
        container.innerHTML += '<div class="chat-msg assistant"><div class="msg-avatar">&#10022;</div><div class="msg-bubble">Processing your request. Let me generate the optimal solution...</div></div>';
        container.scrollTop = container.scrollHeight;
    });
}
</script>
@endpush
@endsection