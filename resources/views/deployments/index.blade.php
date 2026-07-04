@extends('layouts.app')
@section('page-title', 'Deployments')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
    <div>
        <h2 style="font-size:1.25rem;font-weight:700;">Deployments</h2>
        <p style="font-size:0.85rem;color:#64748b;">Track all deployment history</p>
    </div>
</div>

@if($deployments->isEmpty())
<div style="text-align:center;padding:4rem 2rem;">
    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.5" style="margin:0 auto 1rem;"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/></svg>
    <h3 style="font-weight:600;margin-bottom:0.5rem;">No deployments yet</h3>
    <p style="color:#64748b;font-size:0.85rem;">Deploy a project to see it here</p>
</div>
@else
<div class="card" style="padding:0;overflow-x:auto;">
    <table class="data-table">
        <thead><tr>
            <th>Project</th><th>Status</th><th>Version</th><th>Started</th><th>Duration</th>
        </tr></thead>
        <tbody>
        @foreach($deployments as $d)
        <tr style="cursor:pointer;" onclick="this.nextElementSibling.style.display=this.nextElementSibling.style.display==='none'?'table-row':'none'">
            <td style="font-weight:500;">{{ $d->project?->name ?? '—' }}</td>
            <td><span class="badge badge-{{ $d->status === 'live' ? 'green' : ($d->status === 'failed' ? 'red' : ($d->status === 'pending' ? 'amber' : 'blue')) }}">{{ ucfirst($d->status) }}</span></td>
            <td style="font-family:'Fira Code',monospace;font-size:0.8rem;">{{ $d->version }}</td>
            <td>{{ $d->started_at?->diffForHumans() }}</td>
            <td>{{ $d->duration ? $d->duration . 's' : '—' }}</td>
        </tr>
        <tr style="display:none;">
            <td colspan="5" style="background:#0d0d15;padding:1rem;">
                <pre style="font-family:'Fira Code',monospace;font-size:0.75rem;color:#94a3b8;white-space:pre-wrap;max-height:200px;overflow-y:auto;">{{ $d->log }}</pre>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection