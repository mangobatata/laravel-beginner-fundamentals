<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Poll;
use App\Models\Option;
use App\Models\Vote;

new class extends Component {

    public ?int $editingPollId = null;
    public string $editTitle = '';
    public string $editContent = '';

    #[On('pollCreated')]
    public function refreshPolls(): void
    {
    }

    public function with(): array
    {
        return [
            'polls' => Poll::with(['options.votes'])->latest()->get()
        ];
    }

    public function vote(int $optionId): void
    {
        $voterIp = request()->ip();
        $option = Option::with('poll.options')->findOrFail($optionId);

        $alreadyVoted = Vote::whereIn('option_id', $option->poll->options->pluck('id'))
            ->where('voter_ip', $voterIp)
            ->exists();

        if ($alreadyVoted) {
            session()->flash('error', 'You already voted on this poll.');
            return;
        }

        Vote::create(['option_id' => $optionId, 'voter_ip' => $voterIp]);
        session()->flash('success', 'Vote registered!');
    }

    public function startEditing(int $pollId): void
    {
        $poll = Poll::findOrFail($pollId);
        $this->editingPollId = $pollId;
        $this->editTitle = $poll->title ?? '';
        $this->editContent = $poll->content ?? '';
    }

    public function cancelEditing(): void
    {
        $this->editingPollId = null;
        $this->editTitle = '';
        $this->editContent = '';
    }

    public function updatePoll(): void
    {
        $this->validate([
            'editTitle' => 'required|min:3|max:255',
            'editContent' => 'required|min:13|max:255',
        ]);

        Poll::findOrFail($this->editingPollId)->update([
            'title' => $this->editTitle,
            'content' => $this->editContent,
        ]);

        $this->cancelEditing();
        session()->flash('success', 'Poll updated!');
    }

    public function deletePoll(int $pollId): void
    {
        Poll::findOrFail($pollId)->delete();
        session()->flash('success', 'Poll deleted!');
    }
};
?>

<div class="space-y-4">

    @if (session('success'))
        <div class="rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-xs text-emerald-700 font-mono">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-xs text-red-600 font-mono">
            ✕ {{ session('error') }}
        </div>
    @endif

    @forelse ($polls as $poll)
        <div class="bg-white border border-zinc-200 rounded-2xl p-7">

            @if ($editingPollId === $poll->id)
                {{-- Edit mode ───────────────────────────── --}}
                <div class="space-y-3">
                    <input type="text" wire:model.live="editTitle"
                        class="w-full bg-zinc-50 border border-zinc-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-zinc-900 focus:bg-white transition-colors" />
                    @error('editTitle')
                        <p class="text-[11px] text-red-500 font-mono">{{ $message }}</p>
                    @enderror

                    <textarea wire:model.live="editContent" rows="3"
                        class="w-full bg-zinc-50 border border-zinc-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-zinc-900 focus:bg-white transition-colors resize-none"></textarea>
                    @error('editContent')
                        <p class="text-[11px] text-red-500 font-mono">{{ $message }}</p>
                    @enderror

                    <div class="flex gap-2 pt-1">
                        <button wire:click="updatePoll"
                            class="bg-zinc-900 hover:bg-zinc-700 text-amber-50 font-mono text-xs tracking-widest uppercase rounded-lg px-5 py-2.5 transition-colors">Save</button>
                        <button wire:click="cancelEditing"
                            class="border border-zinc-200 hover:border-zinc-400 text-zinc-500 font-mono text-xs tracking-widest uppercase rounded-lg px-5 py-2.5 transition-colors">Cancel</button>
                    </div>
                </div>

            @else
                {{-- View mode ───────────────────────────── --}}
                <div class="flex items-start justify-between mb-1">
                    <h3 class="font-display text-xl font-bold text-zinc-900 leading-snug">
                        {{ $poll->title }}
                    </h3>
                    <div class="flex gap-1 ml-4 shrink-0">
                        <button wire:click="startEditing({{ $poll->id }})"
                            class="font-mono text-[10px] uppercase tracking-widest text-zinc-300 hover:text-zinc-700 px-2 py-1 transition-colors">edit</button>
                        <button wire:click="deletePoll({{ $poll->id }})" wire:confirm="Delete this poll?"
                            class="font-mono text-[10px] uppercase tracking-widest text-zinc-300 hover:text-red-500 px-2 py-1 transition-colors">delete</button>
                    </div>
                </div>

                <p class="text-sm text-zinc-400 font-light mb-5">{{ $poll->content }}</p>

                {{-- Options ─────────────────────────────── --}}
                <div class="space-y-2">
                    @foreach ($poll->options as $option)
                        @php $voteCount = $option->votes->count(); @endphp
                        <div
                            class="flex items-center justify-between border border-zinc-100 hover:border-zinc-300 rounded-lg px-4 py-3 transition-colors group">
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-zinc-800">{{ $option->name }}</span>
                                <span class="font-mono text-[10px] text-zinc-300">
                                    {{ $voteCount }} {{ Str::plural('vote', $voteCount) }}
                                </span>
                            </div>
                            <button wire:click="vote({{ $option->id }})"
                                class="font-mono text-[10px] uppercase tracking-widest bg-zinc-900 hover:bg-zinc-700 text-amber-50 rounded-md px-3 py-1.5 opacity-0 group-hover:opacity-100 transition-all">Vote</button>
                        </div>
                    @endforeach
                </div>

                <p class="mt-5 font-mono text-[10px] text-zinc-300 tracking-wide">
                    {{ $poll->created_at->diffForHumans() }}
                </p>
            @endif

        </div>

    @empty
        <div class="bg-white border border-zinc-200 rounded-2xl p-12 text-center">
            <p class="text-3xl mb-3">📭</p>
            <p class="font-display text-lg font-bold text-zinc-700 mb-1">No polls yet</p>
            <p class="font-mono text-[11px] text-zinc-400 tracking-wide">Create the first one above</p>
        </div>
    @endforelse

</div>