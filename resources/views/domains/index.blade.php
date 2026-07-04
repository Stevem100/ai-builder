@extends('layouts.app')
@section('page-title', 'Custom Domains')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
    <div>
        <h2 style="font-size:1.25rem;font-weight:700;">Custom Domains</h2>
        <p style="font-size:0.85rem;color:#64748b;">Manage custom domains for your projects</p>
    </div>
    <button class="btn btn-primary" onclick="document.getElementById('addDomainForm').style.display=document.getElementById('addDomainForm').style.display==='none'?'block':'none'">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
        Add Domain
    </button>
</div>

{{-- Add domain form --}}
<div id="addDomainForm" style="display:none;" class="card mb-6">
    <form method="POST" action="{{ route('domains.store') }}" style="display:flex;gap:0.75rem;align-items:flex-end;flex-wrap:wrap;">
        @csrf
        <div style="flex:1;min-width:200px;">
            <label class="form-label">Domain</label>
            <input type="text" name="domain" class="form-input" placeholder="app.example.com" required>
        </div>
        <div style="min-width:200px;">
            <label class="form-label">Project</label>
            <select name="project_id" class="form-input" required>
                <option value="">Select project...</option>
                @foreach($projects as $p)
                <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</div>

@if($domains->isEmpty())
<div style="text-align:center;padding:4rem 2rem;">
    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.5" style="margin:0 auto 1rem;"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
    <h3 style="font-weight:600;margin-bottom:0.5rem;">No custom domains</h3>
    <p style="color:#64748b;font-size:0.85rem;">Add a domain to get started</p>
</div>
@else
<div class="card" style="padding:0;overflow-x:auto;">
    <table class="data-table">
        <thead><tr><th>Domain</th><th>Project</th><th>SSL</th><th>Verified</th><th>DNS</th><th></th></tr></thead>
        <tbody>
        @foreach($domains as $d)
        <tr>
            <td style="font-family:'Fira Code',monospace;font-size:0.85rem;">{{ $d->domain }}</td>
            <td>{{ $d->project?->name ?? '—' }}</td>
            <td><span class="badge {{ $d->ssl_enabled ? 'badge-green' : 'badge-gray' }}">{{ $d->ssl_enabled ? 'Enabled' : 'Off' }}</span></td>
            <td><span class="badge {{ $d->verified ? 'badge-green' : 'badge-amber' }}">{{ $d->verified ? 'Verified' : 'Pending' }}</span></td>
            <td><span class="badge badge-{{ $d->dns_status === 'verified' ? 'green' : 'amber' }}">{{ ucfirst($d->dns_status) }}</span></td>
            <td>
                <form method="POST" action="{{ route('domains.destroy', $d) }}" onsubmit="return confirm('Remove this domain?')" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-ghost btn-sm" style="color:#ef4444;padding:0.25rem 0.5rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/></svg>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection