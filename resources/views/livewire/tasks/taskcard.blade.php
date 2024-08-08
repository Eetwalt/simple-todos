<?php

use Livewire\Volt\Component;

new class extends Component {
    public $task;
}; ?>

<div
    class="h-48 p-5 transition-all duration-300 border rounded-lg text-primary bg-base-200/90 border-primary/20 hover:border-primary/50 hover:shadow-lg shadow-black">
    <div class="flex flex-col h-full">
        <div class="space-y-4">
            <div class="flex items-center justify-between w-full">
                <button wire:click="$parent.openModal({{ $task->id }})"
                    class="text-xl font-semibold text-gray-300 transition-all duration-300 border-b-2 border-transparent cursor-pointer hover:border-gray-300">
                    {{ $task->title }}
                </button>
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
                {{ Str::limit($task->description, 170) }}
            </p>
        </div>
        <div class="flex items-end justify-between mt-auto">
            <p class="text-xs opacity-75">Due: {{ Carbon\Carbon::parse($task->due_date)->format('d.m.Y') }}</p>
            <div class="gap-2">
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
</div>
