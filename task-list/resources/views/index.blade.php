@extends('layouts.app')

@section('title', 'My Tasks — TaskFlow')

@section('content')

  <h1 class="font-display font-extrabold text-5xl tracking-tight leading-none text-ink mb-10">
    My <span class="text-accent">Tasks.</span>
  </h1>

  @forelse ($tasks as $task)

    <div class="bg-white border border-border rounded-card px-6 py-4 mb-3.5 shadow-card
                    hover:shadow-card-hover transition-all duration-200
                    flex items-center justify-between gap-4">

      <div class="flex items-center gap-3.5 min-w-0">
        <span class="w-2.5 h-2.5 rounded-full flex-shrink-0
                         {{ $task->completed ? 'bg-emerald-500' : 'bg-amber-400' }}">
        </span>
        <a href="{{ route('tasks.show', $task->id) }}"
          class="font-medium text-[1.05rem] text-ink hover:text-accent transition-colors truncate no-underline">
          {{ $task->title }}
        </a>
      </div>

      <div class="flex items-center gap-2 flex-shrink-0">
        @if ($task->completed)
          <span class="bg-success-bg text-success-text border border-success-ring
                             px-3 py-0.5 rounded-full text-xs font-semibold tracking-wide">
            Done
          </span>
        @else
          <span class="bg-warn-bg text-warn-text border border-warn-ring
                             px-3 py-0.5 rounded-full text-xs font-semibold tracking-wide">
            Pending
          </span>
        @endif

        <a href="{{ route('tasks.show', $task->id) }}" class="inline-flex items-center bg-cream border border-border text-ink text-xs font-medium
                      px-3 py-1.5 rounded-lg hover:bg-border transition-colors no-underline">
          View →
        </a>
      </div>

    </div>

  @empty

    <div class="text-center py-20 text-muted">
      <div class="text-5xl mb-4 opacity-40">📋</div>
      <p class="text-lg">No tasks yet — create your first one!</p>
    </div>

  @endforelse

  @if ($tasks->count())
    <div class="mt-8 flex justify-center">
      {{ $tasks->links() }}
    </div>
  @endif

@endsection