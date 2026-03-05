@extends('layouts.app')

@section('title', isset($task) ? 'Edit Task — TaskFlow' : 'New Task — TaskFlow')

@section('content')

  <a href="{{ route('tasks.index') }}"
    class="inline-flex items-center gap-1 text-sm text-muted hover:text-accent transition-colors mb-5 no-underline">
    ← All tasks
  </a>

  <h1 class="font-display font-extrabold text-5xl tracking-tight leading-none text-ink mb-10">
    @isset($task)
      Edit <span class="text-accent">Task.</span>
    @else
      New <span class="text-accent">Task.</span>
    @endisset
  </h1>

  <div class="bg-white border border-border rounded-card p-8 shadow-card">

    <form method="POST" action="{{ isset($task) ? route('tasks.update', ['task' => $task->id]) : route('tasks.store') }}">
      @csrf
      @isset($task)
        @method('PUT')
      @endisset

      {{-- Title --}}
      <div class="mb-6">
        <label for="title" class="block text-[0.75rem] font-semibold uppercase tracking-widest text-muted mb-1.5">
          Title
        </label>
        <input type="text" name="title" id="title" value="{{ $task->title ?? old('title') }}"
          placeholder="What needs to be done?" class="w-full bg-paper border-[1.5px] border-border rounded-lg px-3.5 py-2.5
                        text-base text-ink placeholder:text-muted/60
                        focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent-light focus:bg-white
                        transition-all duration-150" />
        @error('title')
          <p class="text-[#c0392b] text-xs mt-1.5">{{ $message }}</p>
        @enderror
      </div>

      {{-- Description --}}
      <div class="mb-6">
        <label for="description" class="block text-[0.75rem] font-semibold uppercase tracking-widest text-muted mb-1.5">
          Short Description
        </label>
        <textarea name="description" id="description" rows="3" placeholder="Brief summary…" class="w-full bg-paper border-[1.5px] border-border rounded-lg px-3.5 py-2.5
                           text-base text-ink placeholder:text-muted/60 resize-y
                           focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent-light focus:bg-white
                           transition-all duration-150">{{ $task->description ?? old('description') }}</textarea>
        @error('description')
          <p class="text-[#c0392b] text-xs mt-1.5">{{ $message }}</p>
        @enderror
      </div>

      {{-- Long description --}}
      <div class="mb-6">
        <label for="long_description"
          class="block text-[0.75rem] font-semibold uppercase tracking-widest text-muted mb-1.5">
          Full Details
          <span class="normal-case font-normal tracking-normal text-muted ml-1">(optional)</span>
        </label>
        <textarea name="long_description" id="long_description" rows="7"
          placeholder="Add any extra context or notes here…"
          class="w-full bg-paper border-[1.5px] border-border rounded-lg px-3.5 py-2.5
                           text-base text-ink placeholder:text-muted/60 resize-y
                           focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent-light focus:bg-white
                           transition-all duration-150">{{ $task->long_description ?? old('long_description') }}</textarea>
        @error('long_description')
          <p class="text-[#c0392b] text-xs mt-1.5">{{ $message }}</p>
        @enderror
      </div>

      <div class="h-px bg-border my-6"></div>

      {{-- Actions --}}
      <div class="flex items-center justify-end gap-2.5">
        <a href="{{ route('tasks.index') }}" class="inline-flex items-center bg-cream border border-border text-ink text-sm font-medium
                    px-4 py-2 rounded-lg hover:bg-border transition-colors no-underline">
          Cancel
        </a>
        <button type="submit"
          class="inline-flex items-center gap-1.5 bg-accent hover:bg-accent-dark text-white
                         text-sm font-medium px-5 py-2 rounded-lg transition-all duration-150 hover:-translate-y-px cursor-pointer">
          @isset($task)
            💾 Update Task
          @else
            ✚ Create Task
          @endisset
        </button>
      </div>

    </form>
  </div>

@endsection