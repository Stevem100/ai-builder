@extends('layouts.app')
@section('page-title', 'Terminal — ' . $project->name)
@section('content')
<div style="display:flex;gap:1.5rem;height:calc(100vh - 56px - 40px - 3rem);" class="flex-col md:flex-row">

    <div style="flex:1;display:flex;flex-direction:column;">
        <div class="terminal" style="flex:1;">
            <div class="terminal-header">
                <div class="terminal-dot" style="background:#ef4444;"></div>
                <div class="terminal-dot" style="background:#f59e0b;"></div>
                <div class="terminal-dot" style="background:#10b981;"></div>
                <span style="margin-left:0.5rem;font-size:0.75rem;color:#94a3b8;">{{ $project->name }} — bash</span>
            </div>
            <div class="terminal-body" id="terminalOutput">
                <div><span class="prompt">ai-builder@{{ Str::slug($project->name) }}:~$</span> cd /app && npm install</div>
                <div class="output">added 342 packages in 4.2s</div>
                <div><span class="prompt">ai-builder@{{ Str::slug($project->name) }}:~$</span> npm run build</div>
                <div class="output"> Building for production...</div>
                <div class="success">&#10003; Build completed in 3.8s</div>
                <div class="output"> dist/index.html    0.45 kB │ gzip: 0.30 kB</div>
                <div class="output"> dist/assets/app.js  24.5 kB │ gzip: 8.2 kB</div>
                <div class="output"> dist/assets/app.css  2.1 kB │ gzip: 0.8 kB</div>
                <div><span class="prompt">ai-builder@{{ Str::slug($project->name) }}:~$</span> php artisan serve --port=8000</div>
                <div class="success"> Server running on http://localhost:8000</div>
            </div>
            <div class="terminal-input-area">
                <span style="color:#3b82f6;font-family:'Fira Code',monospace;font-size:0.8rem;">ai-builder@{{ Str::slug($project->name) }}:~$</span>
                <input type="text" id="termInput" placeholder="Type a command..." onkeydown="if(event.key==='Enter')runCmd()">
            </div>
        </div>
    </div>

    {{-- Container status --}}
    <div style="width:220px;flex-shrink:0;" class="hidden md:block">
        <div class="card" style="margin-bottom:1rem;">
            <div style="font-weight:600;font-size:0.85rem;margin-bottom:0.75rem;">Container Status</div>
            @foreach([
                ['name'=>'Nginx','status'=>'Running','color'=>'green'],
                ['name'=>'App (PHP/Node)','status'=>'Running','color'=>'green'],
                ['name'=>'Database','status'=>'Running','color'=>'green'],
                ['name'=>'Redis','status'=>'Running','color'=>'green'],
            ] as $c)
            <div style="display:flex;justify-content:space-between;align-items:center;padding:0.375rem 0;border-bottom:1px solid #1e293b;">
                <span style="font-size:0.8rem;">{{ $c['name'] }}</span>
                <span class="badge badge-{{ $c['color'] }}">{{ $c['status'] }}</span>
            </div>
            @endforeach
        </div>
        <div class="card">
            <div style="font-weight:600;font-size:0.85rem;margin-bottom:0.75rem;">Resources</div>
            <div style="font-size:0.8rem;color:#94a3b8;">CPU: <span style="color:#e2e8f0;">12%</span></div>
            <div class="progress-bar" style="margin:4px 0 8px;"><div class="progress-fill" style="width:12%;background:#10b981;"></div></div>
            <div style="font-size:0.8rem;color:#94a3b8;">Memory: <span style="color:#e2e8f0;">128 MB</span></div>
            <div class="progress-bar" style="margin:4px 0 8px;"><div class="progress-fill" style="width:25%;background:#3b82f6;"></div></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function runCmd() {
    const input = document.getElementById('termInput');
    const cmd = input.value.trim();
    if (!cmd) return;
    const out = document.getElementById('terminalOutput');
    out.innerHTML += '<div><span class="prompt">ai-builder@{{ Str::slug($project->name) }}:~$</span> ' + cmd.replace(/</g,'&lt;') + '</div>';
    if (cmd === 'clear') { out.innerHTML = ''; } else {
        out.innerHTML += '<div class="output">command executed: ' + cmd.replace(/</g,'&lt;') + '</div>';
    }
    input.value = '';
    out.scrollTop = out.scrollHeight;
}
</script>
@endpush
@endsection