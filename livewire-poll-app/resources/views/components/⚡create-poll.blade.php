<?php

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Poll;
use Illuminate\Support\Facades\DB;

new class extends Component {

    #[Validate('required|min:3|max:255')]
    public string $title = '';

    #[Validate('required|min:13|max:255')]
    public string $content = '';

    #[Validate(['options' => 'required|array|min:2', 'options.*' => 'required|string|min:1|max:255'])]
    public array $options = ['', ''];

    public function addOption(): void
    {
        $this->options[] = '';
    }

    public function removeOption(int $index): void
    {
        if (count($this->options) <= 2)
            return;
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function createPoll(): void
    {
        $this->validate();

        DB::transaction(function () {
            $poll = Poll::create([
                'title' => $this->title,
                'content' => $this->content,
            ]);

            $poll->options()->createMany(
                collect($this->options)
                    ->filter()
                    ->map(fn($name) => ['name' => $name])
                    ->values()
                    ->toArray()
            );
        });

        $this->reset(['title', 'content', 'options']);
        $this->options = ['', ''];
        $this->dispatch('pollCreated');
        session()->flash('success', 'Poll created!');
    }
};
?>

<div class="bg-white border border-zinc-200 rounded-2xl p-7">

    @if (session('success'))
        <div class="mb-5 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-xs text-emerald-700 font-mono">
            ✓ {{ session('success') }}
        </div>
    @endif

    <form wire:submit="createPoll">

        {{-- Title --}}
        <div class="mb-5">
            <label class="block font-mono text-[10px] uppercase tracking-widest text-zinc-400 mb-2">Title</label>
            <input type="text" wire:model.live="title" placeholder="What do you want to ask?"
                class="w-full bg-zinc-50 border border-zinc-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-zinc-900 focus:bg-white transition-colors placeholder:text-zinc-300" />
            @error('title')
                <p class="mt-1.5 text-[11px] text-red-500 font-mono">{{ $message }}</p>
            @enderror
        </div>

        {{-- Content --}}
        <div class="mb-5">
            <label class="block font-mono text-[10px] uppercase tracking-widest text-zinc-400 mb-2">Description</label>
            <textarea wire:model.live="content" rows="3" placeholder="Add some context..."
                class="w-full bg-zinc-50 border border-zinc-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-zinc-900 focus:bg-white transition-colors placeholder:text-zinc-300 resize-none"></textarea>
            @error('content')
                <p class="mt-1.5 text-[11px] text-red-500 font-mono">{{ $message }}</p>
            @enderror
        </div>

        {{-- Options --}}
        <div class="mb-6">
            <label class="block font-mono text-[10px] uppercase tracking-widest text-zinc-400 mb-2">Options</label>

            <div class="space-y-2">
                @foreach ($options as $index => $option)
                    <div class="flex items-center gap-2">
                        <span class="font-mono text-[10px] text-zinc-300 w-4 shrink-0">{{ $index + 1 }}</span>
                        <input type="text" wire:model.live="options.{{ $index }}" placeholder="Option {{ $index + 1 }}"
                            class="flex-1 bg-zinc-50 border border-zinc-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-zinc-900 focus:bg-white transition-colors placeholder:text-zinc-300" />
                        @if (count($options) > 2)
                            <button wire:click.prevent="removeOption({{ $index }})"
                                class="text-zinc-300 hover:text-red-400 font-mono text-xs transition-colors px-1">✕</button>
                        @endif
                    </div>
                    @error("options.{$index}")
                        <p class="ml-6 text-[11px] text-red-500 font-mono">{{ $message }}</p>
                    @enderror
                @endforeach
            </div>

            @error('options')
                <p class="mt-1.5 text-[11px] text-red-500 font-mono">{{ $message }}</p>
            @enderror

            <button wire:click.prevent="addOption"
                class="mt-3 font-mono text-[11px] text-zinc-400 hover:text-zinc-900 tracking-wide transition-colors">
                + add option
            </button>
        </div>

        <button type="submit"
            class="w-full bg-zinc-900 hover:bg-zinc-700 text-amber-50 font-mono text-xs tracking-widest uppercase rounded-lg py-3 transition-colors">
            Publish Poll
        </button>

    </form>
</div>