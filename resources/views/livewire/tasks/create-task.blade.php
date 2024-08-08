<?php

use Livewire\Volt\Component;

new class extends Component {
    public bool $createTaskModal = false;

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

<div>
    <x-mary-modal wire:model="createTaskModal" class="backdrop-blur">
        <x-slot name="title" class="!text-black">
            Add a new task
        </x-slot>
        <x-slot name="slot" class="!text-black">
            <form class="flex flex-col gap-4" wire:submit.prevent="create">
                <x-mary-input label="Title" placeholder="Enter a title" required wire:model="taskTitle" />
                <x-mary-textarea label="Description" placeholder="Enter a description" wire:model="taskDescription" />
                <x-mary-input label="Link" placeholder="Link to a resource" wire:model="taskLink" icon="o-link" />
                <x-mary-datetime label="Due date" placeholder="Select a date" wire:model="taskDueDate"
                    icon="o-calendar" />
                <x-mary-button label="Create" type="submit" spinner="create" class="btn-primary" />
            </form>
        </x-slot>

        <x-mary-button label="Cancel" @click="$wire.createTaskModal = false" />
    </x-mary-modal>

    <x-mary-button label="Create task" @click="$wire.createTaskModal = true" class="self-end btn-primary"
        icon-right="o-plus" />
</div>
