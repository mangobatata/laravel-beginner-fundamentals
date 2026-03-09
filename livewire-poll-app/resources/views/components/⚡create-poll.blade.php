<?php

use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {
    // ✅ Validación moderna de Livewire 3 con atributo #[Validate]
    #[Validate('required|min:3|max:255')]
    public string $title = ''; 

};
?>

<div class="bg-white rounded-2xl shadow-sm ring-1 ring-stone-200 p-6">
    <h1 class="text-2xl font-bold text-stone-900 mb-6">Create Poll</h1>

    <form wire:submit="$refresh">

        <label class="block text-sm font-medium text-stone-700 mb-1">
            Poll Title
        </label>

        <input type="text" wire:model.live="title" placeholder="e.g. What's your favorite language?"
            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-stone-400" />

        {{-- ✅ Mensajes de error de validación --}}
        @error('title')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror

        {{-- ✅ wire:model.live actualiza en tiempo real sin submit --}}
        @if($title)
            <p class="mt-3 text-sm text-stone-500">
                Preview: <span class="font-medium text-stone-800">{{ $title }}</span>
            </p>
        @endif

        <button type="submit"
            class="mt-4 rounded-lg bg-stone-900 px-4 py-2 text-sm text-white hover:bg-stone-700 transition-colors">
            Create Poll
        </button>

    </form>
</div>