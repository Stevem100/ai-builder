@extends('layouts.app')
@section('page-title', 'Editor — ' . $project->name)
@section('content')
<div style="display:flex;gap:0;height:calc(100vh - 56px - 40px - 3rem);">

    {{-- File tree --}}
    <div style="width:200px;background:#12121a;border-right:1px solid #1e293b;flex-shrink:0;overflow-y:auto;padding:0.5rem 0;">
        <div style="padding:0.375rem 0.75rem;font-size:0.7rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;">Files</div>
        @foreach($files as $i => $file)
        <div class="file-item {{ $i === 0 ? 'active' : '' }}" onclick="switchFile({{ $i }})" data-index="{{ $i }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/></svg>
            {{ $file['name'] }}
        </div>
        @endforeach
    </div>

    {{-- Editor area --}}
    <div style="flex:1;display:flex;flex-direction:column;min-width:0;">
        <div style="background:#12121a;border-bottom:1px solid #1e293b;padding:0.5rem 1rem;display:flex;align-items:center;gap:0.75rem;">
            <span id="editorFileName" style="font-size:0.8rem;color:#e2e8f0;">{{ $files[0]['name'] }}</span>
            <span id="editorLang" class="badge badge-gray" style="font-size:0.65rem;">{{ $files[0]['lang'] }}</span>
        </div>
        <div style="flex:1;position:relative;">
            <textarea id="codeEditor" style="width:100%;height:100%;background:#0a0a0f;color:#e2e8f0;border:none;padding:1rem;font-family:'Fira Code',monospace;font-size:0.8rem;line-height:1.6;resize:none;outline:none;tab-size:2;">{{ $files[0]['content'] }}</textarea>
        </div>
    </div>
</div>

@push('scripts')
<script>
const files = @json($files);
function switchFile(idx) {
    document.querySelectorAll('.file-item').forEach((el,i) => el.classList.toggle('active', i === idx));
    document.getElementById('codeEditor').value = files[idx].content;
    document.getElementById('editorFileName').textContent = files[idx].name;
    document.getElementById('editorLang').textContent = files[idx].lang;
}
document.getElementById('codeEditor').addEventListener('keydown', function(e) {
    if (e.key === 'Tab') { e.preventDefault(); const s = this.selectionStart; this.value = this.value.substring(0,s) + '  ' + this.value.substring(this.selectionEnd); this.selectionStart = this.selectionEnd = s + 2; }
});
</script>
@endpush
@endsection