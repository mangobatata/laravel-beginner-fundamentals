@extends('layouts.app')

@section('content')

  {{-- Create Poll ─────────────────────────────────────── --}}
  <div class="mb-14">
    <div class="flex items-center gap-3 mb-5">
      <span class="font-mono text-[10px] uppercase tracking-widest text-zinc-400">New poll</span>
      <div class="flex-1 h-px bg-zinc-200"></div>
    </div>
    @livewire('create-poll')
  </div>

  {{-- Available Polls ──────────────────────────────────── --}}
  <div>
    <div class="flex items-center gap-3 mb-5">
      <span class="font-mono text-[10px] uppercase tracking-widest text-zinc-400">Available polls</span>
      <div class="flex-1 h-px bg-zinc-200"></div>
    </div>
    @livewire('polls')
  </div>

@endsection