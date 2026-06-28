@extends('layouts.app')
@section('page-title', $project->name)
@section('content')
<div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;">
    <div>
        <h2 style="font-size:1.25rem;font-weight:700;">{{ $project->name }}</h2>
        <p style="font-size:0.85rem;color:#64748b;">{{ $project->description ?? 'No description' }}</p>
    </div>
    <div style="margin-left:auto;display:flex;gap:0.5rem;flex-wrap:wrap;">
        <span class="badge {{ $project->type === 'frontend' ? 'badge-blue' : ($project->type === 'backend' ? 'badge-green' : 'badge-purple') }}">{{ ucfirst($project->type) }}</span>
        <span class="badge {{ $project->status === 'active' ? 'badge-green' : 'badge-amber' }}">{{ ucfirst($project->status) }}</span>
        <span class="badge badge-gray">{{ $project->framework ?? 'Custom' }}</span>
    </div>
</div>

{{-- Stats row --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem;" class="grid grid-cols-1 sm:grid-cols-3">
    <div class="card" style="text-align:center;padding:1rem;">
        <div style="font-size:1.5rem;font-weight:700;">{{ $project->deployments->count() }}</div>
        <div style="font-size:0.8rem;color:#64748b;">Deployments</div>
    </div>
    <div class="card" style="text-align:center;padding:1rem;">
        <div style="font-size:1.5rem;font-weight:700;">{{ optional($project->deployments->first())->completed_at?->diffForHumans() ?? 'Never' }}</div>
        <div style="font-size:0.8rem;color:#64748b;">Last Deployed</div>
    </div>
    <div class="card" style="text-align:center;padding:1rem;">
        <div style="font-size:1.5rem;font-weight:700;">{{ number_format($project->storage_used / 1024, 1) }} MB</div>
        <div style="font-size:0.8rem;color:#64748b;">Storage Used</div>
    </div>
</div>

{{-- Actions --}}
<div style="display:flex;gap:0.5rem;margin-bottom:1.5rem;flex-wrap:wrap;">
    <a href="{{ route('projects.editor', $project) }}" class="btn btn-primary btn-sm">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m16 18 2-2-8.5-8.5-3 3L15 18Zm0 0 2.5 2.5"/></svg>
        Open Editor
    </a>
    <a href="{{ route('projects.terminal', $project) }}" class="btn btn-ghost btn-sm">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="4 17 10 11 4 5"/><line x1="12" y1="19" x2="20" y2="19"/></svg>
        Terminal
    </a>
    <a href="{{ route('projects.preview', $project) }}" class="btn btn-ghost btn-sm">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        Preview
    </a>
    <form method="POST" action="{{ route('deployments.deploy', $project) }}" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-success btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/></svg>
            Deploy Now
        </button>
    </form>
</div>

{{-- File tree --}}
<div class="card">
    <div style="font-weight:600;font-size:0.9rem;margin-bottom:0.75rem;">Project Files</div>
    @foreach($files as $file)
    <div class="file-item">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
        {{ $file['name'] }}
        <span style="margin-left:auto;font-size:0.7rem;color:#64748b;">{{ $file['lang'] }}</span>
    </div>
    @endforeach
</div>
@endsection