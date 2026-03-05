@extends('layouts.app')

@section('title', $task->title . ' — TaskFlow')

@section('content')

  <a href="{{ route('tasks.index') }}"
    class="inline-flex items-center gap-1 text-sm text-muted hover:text-accent transition-colors mb-5 no-underline">
    ← All tasks
  </a>

  {{-- ── Main card ── --}}
  <div class="bg-white border border-border rounded-card p-8 mb-3.5 shadow-card">

    <div class="flex items-start justify-between gap-4 flex-wrap mb-5">
      <h2 class="font-display font-bold text-[1.75rem] leading-tight tracking-tight">
        {{ $task->title }}
      </h2>
      @if ($task->completed)
        <span class="bg-success-bg text-success-text border border-success-ring
                         px-3 py-1 rounded-full text-xs font-semibold tracking-wide">
          Completed ✅
        </span>
      @else
        <span class="bg-warn-bg text-warn-text border border-warn-ring
                         px-3 py-1 rounded-full text-xs font-semibold tracking-wide">
          Pending ⏳
        </span>
      @endif
    </div>

    @if ($task->description)
      <p class="text-[#444] text-base leading-relaxed mb-4">{{ $task->description }}</p>
    @endif

    @if ($task->long_description)
      <div class="h-px bg-border my-6"></div>
      <p class="text-[#555] text-[0.95rem] leading-loose">{{ $task->long_description }}</p>
    @endif

    <div class="h-px bg-border my-6"></div>

    <div class="flex gap-6 text-xs text-muted">
      <span>Created: {{ $task->created_at->format('M d, Y') }}</span>
      <span>Updated: {{ $task->updated_at->format('M d, Y') }}</span>
    </div>

  </div>

  {{-- ── Actions card ── --}}
  <div class="bg-white border border-border rounded-card px-6 py-4 shadow-card flex items-center gap-2.5 flex-wrap">

    <a href="{{ route('tasks.edit', $task->id) }}" class="inline-flex items-center gap-1.5 bg-warn-bg text-warn-text border border-warn-ring
                text-sm font-medium px-4 py-2 rounded-lg hover:bg-amber-100 transition-colors no-underline">
      ✏️ Edit
    </a>

    <form method="POST" action="{{ route('tasks.toggle-complete', $task->id) }}" class="contents">
      @csrf
      @method('PUT')
      <button type="submit" class="inline-flex items-center gap-1.5 bg-cream border border-border text-ink
                       text-sm font-medium px-4 py-2 rounded-lg hover:bg-border transition-colors cursor-pointer">
        {{ $task->completed ? '↩ Mark as Pending' : '✓ Mark as Done' }}
      </button>
    </form>

    <div class="flex-1"></div>

    <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" class="contents">
      @csrf
      @method('DELETE')
      <button type="submit" onclick="return confirm('Delete this task?')" class="inline-flex items-center gap-1.5 border border-[#e8b4b0] text-[#c0392b]
                       text-sm font-medium px-4 py-2 rounded-lg hover:bg-[#fdecea] transition-colors cursor-pointer">
        🗑 Delete
      </button>
    </form>

  </div>

@endsection