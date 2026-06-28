@extends('layouts.app')
@section('page-title', 'Preview — ' . $project->name)
@section('content')
<div>
    {{-- URL bar --}}
    <div style="display:flex;gap:0.5rem;margin-bottom:1rem;align-items:center;">
        <div style="flex:1;background:#12121a;border:1px solid #1e293b;border-radius:0.5rem;padding:0.5rem 1rem;display:flex;align-items:center;gap:0.5rem;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
            <span style="font-size:0.8rem;color:#94a3b8;">https://{{ Str::slug($project->name) }}.aibuilder.dev</span>
        </div>
        <div style="display:flex;gap:0.25rem;">
            <button class="btn btn-ghost btn-sm device-btn active" onclick="setDevice('desktop',this)" title="Desktop">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="12" x="3" y="3" rx="2"/><path d="M8 21h8M12 15v6"/></svg>
            </button>
            <button class="btn btn-ghost btn-sm device-btn" onclick="setDevice('tablet',this)" title="Tablet">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M12 18h.01"/></svg>
            </button>
            <button class="btn btn-ghost btn-sm device-btn" onclick="setDevice('mobile',this)" title="Mobile">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="14" height="20" x="5" y="2" rx="2"/><path d="M12 18h.01"/></svg>
            </button>
        </div>
    </div>

    {{-- Preview frame --}}
    <div id="previewContainer" style="background:#1e293b;border-radius:0.75rem;overflow:hidden;border:1px solid #1e293b;transition:all 0.3s;">
        <div class="preview-wireframe">
            <div class="wireframe-header">
                <div style="width:16px;height:16px;border-radius:50%;background:#cbd5e1;"></div>
                <div style="width:120px;height:8px;background:#cbd5e1;border-radius:4px;"></div>
                <div style="flex:1;"></div>
                <div style="display:flex;gap:8px;">
                    <div style="width:60px;height:8px;background:#cbd5e1;border-radius:4px;"></div>
                    <div style="width:60px;height:8px;background:#cbd5e1;border-radius:4px;"></div>
                </div>
            </div>
            <div class="wireframe-nav">
                <div style="display:flex;align-items:center;padding:0 1rem;height:100%;gap:1rem;">
                    <div style="width:80px;height:8px;background:#94a3b8;border-radius:4px;"></div>
                    <div style="width:50px;height:8px;background:#cbd5e1;border-radius:4px;"></div>
                    <div style="width:50px;height:8px;background:#cbd5e1;border-radius:4px;"></div>
                    <div style="width:50px;height:8px;background:#cbd5e1;border-radius:4px;"></div>
                </div>
            </div>
            <div class="wireframe-hero">
                <span>{{ $project->name }}</span>
            </div>
            <div class="wireframe-content">
                <div class="wireframe-sidebar">
                    <div style="padding:0.75rem;">
                        <div style="width:60px;height:8px;background:#cbd5e1;border-radius:4px;margin-bottom:0.75rem;"></div>
                        @for($i = 0; $i < 5; $i++)
                        <div style="width:100%;height:6px;background:#e2e8f0;border-radius:3px;margin-bottom:0.5rem;"></div>
                        @endfor
                    </div>
                </div>
                <div class="wireframe-main" style="padding:0.75rem;">
                    <div style="width:70%;height:10px;background:#cbd5e1;border-radius:5px;margin-bottom:0.75rem;"></div>
                    <div style="width:100%;height:6px;background:#e2e8f0;border-radius:3px;margin-bottom:0.375rem;"></div>
                    <div style="width:90%;height:6px;background:#e2e8f0;border-radius:3px;margin-bottom:0.375rem;"></div>
                    <div style="width:95%;height:6px;background:#e2e8f0;border-radius:3px;margin-bottom:0.75rem;"></div>
                    <div style="display:flex;gap:0.5rem;margin-top:1rem;">
                        <div style="width:80px;height:32px;background:#3b82f6;border-radius:0.25rem;"></div>
                        <div style="width:80px;height:32px;background:#e2e8f0;border-radius:0.25rem;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function setDevice(device, btn) {
    const container = document.getElementById('previewContainer');
    document.querySelectorAll('.device-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    if (device === 'desktop') container.style.maxWidth = '100%';
    else if (device === 'tablet') container.style.maxWidth = '768px';
    else container.style.maxWidth = '375px';
    container.style.margin = '0 auto';
}
</script>
@endpush
@endsection