<?php

use Livewire\Volt\Component;

new class extends Component {
    public $taskTitle;
    public $taskDescription;
    public $taskLink;
    public $taskDueDate;

    public function create()
    {
        $validated = $this->validate([
            'taskTitle' => ['required', 'string', 'max:45', 'min:3'],
            'taskDescription' => ['max:255'],
            'taskLink' => ['nullable', 'active_url'],
            'taskDueDate' => ['nullable', 'date'],
        ]);

        auth()
            ->user()
            ->tasks()
            ->create([
                'title' => $this->taskTitle,
                'description' => $this->taskDescription,
                'link' => $this->taskLink,
                'due_date' => $this->taskDueDate,
                'status' => 'Todo',
            ]);

        $this->reset();

        $this->dispatch('refreshTaskList');
    }
}; ?>

<x-wui-card>
    <x-slot name="title" class="!text-black">
        Add a new task
    </x-slot>
    <x-slot name="slot" class="!text-black">
        <form class="flex flex-col gap-4" wire:submit.prevent="create">
            <div class="flex gap-6">
                <div class="flex flex-col w-6/12 gap-4">
                    <x-wui-input label="Title" placeholder="Enter a title" required wire:model="taskTitle" />
                    <x-wui-textarea label="Description" placeholder="Enter a description"
                        wire:model="taskDescription" />
                </div>
                <div class="flex flex-col w-6/12 gap-4">
                    <x-wui-input label="Link" placeholder="Link to a resource" wire:model="taskLink" />
                    <x-wui-datetime-picker label="Due Date" placeholder="Select a date" parse-format="DD-MM-YYYY"
                        without-time="true" wire:model="taskDueDate" />
                    <x-wui-button type="submit" class="ml-auto">Create todo</x-wui-button>
                </div>
            </div>
        </form>
    </x-slot>
</x-wui-card>
