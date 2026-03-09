<?php

use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {

    #[Validate('required|min:3|max:255')]
    public string $title = '';

    #[Validate('required|min:13|max:255')]
    public string $content = '';

    public array $options = ['First'];

    // public function save()
    // {
    //     // ✅ Con #[Validate] ya definido arriba, solo llamar $this->validate()
    //     // sin repetir las reglas — evita conflictos y duplicación
    //     $this->validate();

    //     $this->reset('title', 'content');
    // }

    public function addOption()
    {
        $this->options[] = '';
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }
};
?>

<div class="bg-white rounded-2xl shadow-sm ring-1 ring-stone-200 p-6">
    <h1 class="text-2xl font-bold text-stone-900 mb-6">Create Poll</h1>

    {{-- ✅ wire:submit llama a save(), no a $refresh --}}
    <form wire:submit="save">

        {{-- Title --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-stone-700 mb-1">
                Poll Title
            </label>
            <input type="text" wire:model.live="title" placeholder="e.g. What's your favorite language?"
                class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-stone-400" />
            @error('title')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
            @if($title)
                <p class="mt-1 text-xs text-stone-400">
                    Preview: <span class="font-medium text-stone-700">{{ $title }}</span>
                </p>
            @endif
        </div>

        {{-- Content --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-stone-700 mb-1">
                Content
            </label>
            <textarea wire:model.live="content" rows="5" placeholder="Describe your poll..."
                class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-stone-400"></textarea>
            @error('content')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
            @if($content)
                <p class="mt-1 text-xs text-stone-400">
                    Preview: <span class="font-medium text-stone-700">{{ $content }}</span>
                </p>
            @endif
        </div>

        <div class="mb-4 mt-4">
            <button class="btn" wire:click.prevent="addOption">Add Option</button>
        </div>
        <div>
            @foreach ($options as $index => $option)
                <div class="mb-4">
                    <input type="text" wire:model.live="options.{{ $index }}" placeholder="Option {{ $index + 1 }}"
                        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-stone-400" />
                    <button class="btn" wire:click.prevent="removeOption({{ $index }})">Remove</button>
                </div>
            @endforeach
        </div>
    </form>
</div>