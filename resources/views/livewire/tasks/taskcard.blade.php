<?php

use Livewire\Volt\Component;

new class extends Component {
    public $task;
}; ?>

<x-mary-card class="text-primary" title="{{ $task->title }}"
    subtitle="{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}">
    <div class="flex flex-col gap-2">
        {{ $task->description }}
        <x-mary-button label="Complete" class="self-end btn-primary btn-sm" icon-right="o-check" />
    </div>
    <x-slot:menu class="self-start">
        @if ($task->status === 'Todo')
            <x-mary-button icon="o-chevron-right" class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                wire:click="$parent.updateStatus({{ $task->id }}, 'In progress')" />
        @elseif ($task->status === 'In progress')
            <x-mary-button icon="o-chevron-left"
                class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                wire:click="$parent.updateStatus({{ $task->id }}, 'Todo')" />
            <x-mary-button icon="o-chevron-right"
                class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                wire:click="$parent.updateStatus({{ $task->id }}, 'Waiting')" />
        @elseif ($task->status === 'Waiting')
            <x-mary-button icon="o-chevron-left"
                class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                wire:click="$parent.updateStatus({{ $task->id }}, 'In progress')" />
        @endif

    </x-slot:menu>
</x-mary-card>
