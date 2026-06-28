@extends('layouts.app')
@section('page-title', 'Create Project')
@section('content')
<div style="max-width:600px;">
    <h2 style="font-size:1.25rem;font-weight:700;margin-bottom:0.25rem;">Create New Project</h2>
    <p style="font-size:0.85rem;color:#64748b;margin-bottom:1.5rem;">Set up a new application or service</p>

    <div class="card">
        <form method="POST" action="{{ route('projects.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Project Name</label>
                <input type="text" name="name" class="form-input" placeholder="My Awesome App" required value="{{ old('name') }}">
                @error('name')<p style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-input" rows="3" placeholder="What is this project about?">{{ old('description') }}</textarea>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Project Type</label>
                    <select name="type" class="form-input" required>
                        <option value="frontend" {{ old('type') === 'frontend' ? 'selected' : '' }}>Frontend</option>
                        <option value="backend" {{ old('type') === 'backend' ? 'selected' : '' }}>Backend</option>
                        <option value="fullstack" {{ old('type') === 'fullstack' ? 'selected' : '' }}>Fullstack</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Framework</label>
                    <select name="framework" class="form-input">
                        <option value="Next.js">React / Next.js</option>
                        <option value="Vue/Nuxt">Vue / Nuxt</option>
                        <option value="Angular">Angular</option>
                        <option value="Node.js">Node.js</option>
                        <option value="Python/Django">Python / Django</option>
                        <option value="Laravel">Laravel</option>
                        <option value="Custom">Custom</option>
                    </select>
                </div>
            </div>
            <div style="display:flex;gap:0.75rem;margin-top:0.5rem;">
                <button type="submit" class="btn btn-primary">Create Project</button>
                <a href="{{ route('projects.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection