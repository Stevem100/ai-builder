@extends('layouts.app')
@section('page-title', 'Projects')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
    <div>
        <h2 style="font-size:1.25rem;font-weight:700;">Projects</h2>
        <p style="font-size:0.85rem;color:#64748b;margin-top:2px;">Manage your applications and services</p>
    </div>
    <a href="{{ route('projects.create') }}" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
        New Project
    </a>
</div>

@forelse($projects as $project)
<div class="card" style="margin-bottom:1rem;display:flex;align-items:center;gap:1.25rem;flex-wrap:wrap;">
    <div style="width:44px;height:44px;border-radius:0.75rem;background:{{ $project->type === 'frontend' ? 'rgba(59,130,246,0.12)' : ($project->type === 'backend' ? 'rgba(16,185,129,0.12)' : 'rgba(139,92,246,0.12)') }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="{{ $project->type === 'frontend' ? '#3b82f6' : ($project->type === 'backend' ? '#10b981' : '#8b5cf6') }}" stroke-width="2"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>
    </div>
    <div style="flex:1;min-width:200px;">
        <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;">
            <a href="{{ route('projects.show', $project) }}" style="font-weight:600;font-size:0.95rem;color:#e2e8f0;text-decoration:none;">{{ $project->name }}</a>
            <span class="badge {{ $project->type === 'frontend' ? 'badge-blue' : ($project->type === 'backend' ? 'badge-green' : 'badge-purple') }}">{{ ucfirst($project->type) }}</span>
            <span class="badge {{ $project->status === 'active' ? 'badge-green' : ($project->status === 'deploying' ? 'badge-amber' : 'badge-gray') }}">{{ ucfirst($project->status) }}</span>
        </div>
        <p style="font-size:0.8rem;color:#64748b;margin-top:4px;" class="line-clamp-2">{{ $project->description ?? 'No description' }}</p>
        <div style="font-size:0.75rem;color:#64748b;margin-top:4px;">{{ $project->framework ?? 'Custom' }} &middot; {{ $project->deployments_count ?? 0 }} deployments &middot; {{ $project->created_at->diffForHumans() }}</div>
    </div>
    <div style="display:flex;gap:0.5rem;flex-shrink:0;">
        <a href="{{ route('projects.editor', $project) }}" class="btn btn-ghost btn-sm" title="Editor">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m16 18 2-2-8.5-8.5-3 3L15 18Zm0 0 2.5 2.5"/><path d="m2 22 3-3"/></svg>
        </a>
        <form method="POST" action="{{ route('deployments.deploy', $project) }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-ghost btn-sm" title="Deploy">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/></svg>
            </button>
        </form>
        <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Delete this project?')" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-ghost btn-sm" style="color:#ef4444;" title="Delete">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
            </button>
        </form>
    </div>
</div>
@empty
<div style="text-align:center;padding:4rem 2rem;">
    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.5" style="margin:0 auto 1rem;"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>
    <h3 style="font-size:1.1rem;font-weight:600;margin-bottom:0.5rem;">No projects yet</h3>
    <p style="color:#64748b;font-size:0.85rem;margin-bottom:1.5rem;">Create your first project to get started</p>
    <a href="{{ route('projects.create') }}" class="btn btn-primary">Create Project</a>
</div>
@endforelse
@endsection