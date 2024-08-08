<?php

use Livewire\Volt\Component;

new class extends Component {
    public $task;
}; ?>

<div class="p-5 rounded-lg text-primary bg-base-200 min-h-48">
    <div class="flex flex-col h-full">
        <div class="space-y-4">
            <div class="flex items-center justify-between w-full">
                <p class="text-xl font-semibold">
                    {{ $task->title }}
                </p>
                <div class="flex gap-1">
                    @if ($task->status === 'Todo')
                        <x-mary-button icon="o-chevron-right"
                            class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50 text-primary"
                            wire:click="$parent.updateStatus({{ $task->id }}, 'In progress')" />
                    @elseif ($task->status === 'In progress')
                        <x-mary-button icon="o-chevron-left"
                            class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50 text-primary"
                            wire:click="$parent.updateStatus({{ $task->id }}, 'Todo')" />
                        <x-mary-button icon="o-chevron-right"
                            class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50 text-primary"
                            wire:click="$parent.updateStatus({{ $task->id }}, 'Waiting')" />
                    @elseif ($task->status === 'Waiting')
                        <x-mary-button icon="o-chevron-left"
                            class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50 text-primary"
                            wire:click="$parent.updateStatus({{ $task->id }}, 'In progress')" />
                    @endif
                </div>
            </div>
            <p class="text-sm text-primary">
                {{ $task->description }}
            </p>
        </div>
        <div class="flex items-center justify-end gap-2 mt-auto">
            <x-mary-button class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50 text-primary"
                icon="o-eye" wire:click="$parent.openModal({{ $task->id }})" />
            @if ($task->status === 'Done')
                <x-mary-button label="In progress" class="bg-base-300 btn-sm" icon="o-arrow-left"
                    wire:click="$parent.updateStatus({{ $task->id }}, 'In progress')" />
            @else
                <x-mary-button label="Complete" class="btn-primary btn-sm" icon-right="o-check"
                    wire:click="$parent.updateStatus({{ $task->id }}, 'Done')" />
            @endif
        </div>
    </div>
</div>
