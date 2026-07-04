@extends('layouts.app')
@section('page-title', 'Settings')
@section('content')
<div class="tab-bar" style="margin-bottom:1.5rem;">
    <button class="tab-item active" onclick="switchTab('profile',this)">Profile</button>
    <button class="tab-item" onclick="switchTab('environment',this)">Environment Variables</button>
    <button class="tab-item" onclick="switchTab('defaults',this)">Project Defaults</button>
</div>

{{-- Profile Tab --}}
<div id="tab-profile">
    <div class="card" style="max-width:500px;">
        <form method="POST" action="{{ route('settings.update') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-input" value="{{ $user->name }}" required>
                @error('name')<p style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="{{ $user->email }}" required>
                @error('email')<p style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Role</label>
                <input type="text" class="form-input" value="{{ ucfirst($user->role ?? 'admin') }}" disabled>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>

{{-- Environment Tab --}}
<div id="tab-environment" style="display:none;">
    <div class="card" style="max-width:600px;">
        <p style="font-size:0.85rem;color:#94a3b8;margin-bottom:1rem;">Manage environment variables for your projects.</p>
        <div id="envRows">
            @foreach($envVars as $i => $var)
            <div style="display:flex;gap:0.5rem;margin-bottom:0.5rem;" class="env-row">
                <input type="text" class="form-input" value="{{ $var['key'] }}" style="flex:1;" readonly>
                <input type="text" class="form-input" value="{{ $var['value'] }}" style="flex:1;">
                <button type="button" class="btn btn-ghost btn-sm" style="color:#ef4444;" onclick="this.parentElement.remove()">&times;</button>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-ghost btn-sm mt-4" onclick="addEnvRow()">+ Add Variable</button>
        <div style="margin-top:1rem;"><button class="btn btn-primary">Save Variables</button></div>
    </div>
</div>

{{-- Defaults Tab --}}
<div id="tab-defaults" style="display:none;">
    <div class="card" style="max-width:500px;">
        <div class="form-group">
            <label class="form-label">Default Framework</label>
            <select class="form-input">
                <option>React / Next.js</option>
                <option>Vue / Nuxt</option>
                <option>Angular</option>
                <option>Laravel</option>
                <option>Custom</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">PHP Version</label>
            <select class="form-input"><option>8.3</option><option>8.2</option><option>8.1</option></select>
        </div>
        <div class="form-group">
            <label class="form-label">Node.js Version</label>
            <select class="form-input"><option>20 LTS</option><option>18 LTS</option><option>22</option></select>
        </div>
        <div class="form-group">
            <label style="display:flex;align-items:center;gap:0.75rem;cursor:pointer;">
                <div style="width:40px;height:22px;background:#10b981;border-radius:11px;position:relative;">
                    <div style="width:18px;height:18px;background:white;border-radius:50%;position:absolute;top:2px;right:2px;transition:all 0.2s;"></div>
                </div>
                <span style="font-size:0.85rem;color:#e2e8f0;">Auto-deploy on push</span>
            </label>
        </div>
        <button class="btn btn-primary">Save Defaults</button>
    </div>
</div>

@push('scripts')
<script>
function switchTab(name, btn) {
    document.querySelectorAll('[id^="tab-"]').forEach(el => el.style.display = 'none');
    document.getElementById('tab-' + name).style.display = 'block';
    document.querySelectorAll('.tab-item').forEach(el => el.classList.remove('active'));
    btn.classList.add('active');
}
function addEnvRow() {
    const container = document.getElementById('envRows');
    const row = document.createElement('div');
    row.className = 'env-row';
    row.style.cssText = 'display:flex;gap:0.5rem;margin-bottom:0.5rem;';
    row.innerHTML = '<input type="text" class="form-input" placeholder="KEY" style="flex:1;"><input type="text" class="form-input" placeholder="value" style="flex:1;"><button type="button" class="btn btn-ghost btn-sm" style="color:#ef4444;" onclick="this.parentElement.remove()">&times;</button>';
    container.appendChild(row);
}
</script>
@endpush
@endsection