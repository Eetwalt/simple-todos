<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public $todos;
    public $inProgress;
    public $waiting;
    public $done;
    public bool $showDoneTasks = false;
    public bool $taskModal = false;
    public $openTask = null;
    public $editMode = false;
    public $editTaskTitle;
    public $editTaskDescription;
    public $editTaskLink;
    public $editTaskDueDate;

    #[On('refreshTaskList')]
    public function with(): array
    {
        $tasks = Auth::user()->tasks()->latest()->get();
        return [($this->todos = $tasks->where('status', 'Todo')), ($this->inProgress = $tasks->where('status', 'In progress')), ($this->waiting = $tasks->where('status', 'Waiting')), ($this->done = $tasks->where('status', 'Done'))];
    }

    public function updateStatus($id, $status)
    {
        $task = auth()->user()->tasks()->find($id);
        $task->status = $status;
        $task->save();
        $this->dispatch('refreshTaskList');
    }

    public function openModal($id)
    {
        $openTask = auth()->user()->tasks()->find($id);
        $this->openTask = $openTask;
        $this->taskModal = true;
    }

    public function deleteTask($id)
    {
        $task = auth()->user()->tasks()->find($id);
        $task->delete();
        $this->taskModal = false;
        $this->dispatch('refreshTaskList');
    }

    public function editTask($id)
    {
        $task = auth()->user()->tasks()->find($id);
        $this->editTaskTitle = $task->title;
        $this->editTaskDescription = $task->description;
        $this->editTaskLink = $task->link;
        $this->editTaskDueDate = $task->due_date;

        $this->editMode = true;
    }

    public function cancelEditTask()
    {
        $this->editMode = false;
    }

    public function updateTask($id)
    {
        $validated = $this->validate([
            'editTaskTitle' => ['required', 'string', 'max:45', 'min:3'],
            'editTaskDescription' => ['max:255'],
            'editTaskLink' => ['nullable', 'active_url'],
            'editTaskDueDate' => ['nullable', 'date'],
        ]);

        $task = auth()->user()->tasks()->find($id);
        $task->title = $this->editTaskTitle;
        $task->description = $this->editTaskDescription;
        $task->link = $this->editTaskLink;
        $task->due_date = $this->editTaskDueDate;
        $task->save();

        $this->editMode = false;

        $this->dispatch('refreshTaskList');
    }
};

?>

<div class="flex flex-col">
    <x-mary-modal wire:model="taskModal" class="backdrop-blur">
        @if ($openTask)
            <x-slot name="slot" class="!text-black">
                <x-mary-button class="absolute right-6 btn-sm btn-circle" icon="o-x-mark" wire:click="taskModal = false" />

                <div>
                    @if ($editMode)
                        <form wire:submit.prevent="updateTask({{ $openTask->id }})" class="flex flex-col gap-4">
                            <x-mary-input label="Title" placeholder="Enter a title" required
                                wire:model="editTaskTitle" />
                            <x-mary-textarea label="Description" placeholder="Enter a description"
                                wire:model="editTaskDescription" />
                            <x-mary-input label="Link" placeholder="Link to a resource" wire:model="editTaskLink"
                                icon="o-link" />
                            <x-mary-datetime label="Due date" placeholder="Select a date" wire:model="editTaskDueDate"
                                icon="o-calendar" />
                            <div class="flex gap-4">
                                <x-mary-button label="Cancel" type="button" class="flex-1 btn-outline"
                                    wire:click="cancelEditTask" />
                                <x-mary-button label="Update" type="submit" spinner="createTask"
                                    class="flex-1 btn-primary" />
                            </div>
                        </form>
                    @else
                        <div class="flex flex-col gap-4">
                            <p class="text-2xl font-semibold text-gray-300">
                                {{ $openTask->title }}
                            </p>
                            <p>{{ $openTask->description }}</p>
                            <a href="{{ $openTask->link }}" target="_blank"
                                class="text-sm underline text-primary underline-offset-2">
                                {{ $openTask->link }}
                            </a>
                            <p class="text-sm text-primary/75">Due:
                                {{ Carbon\Carbon::parse($openTask->due_date)->format('d.m.Y') }}</p>
                            <div class="flex justify-between gap-2">
                                <div class="flex gap-2">
                                    <x-mary-button class="self-end btn-sm btn-outline" icon-right="o-pencil"
                                        wire:click="editTask({{ $openTask->id }})" />
                                    <x-mary-button class="self-end btn-error btn-sm" icon-right="o-trash"
                                        wire:click="deleteTask({{ $openTask->id }})"
                                        wire:confirm="Are you sure you want to delete this task?" />
                                </div>
                                @if ($openTask->status === 'Done')
                                    <x-mary-button label="In progress" class="bg-base-300 btn-sm" icon="o-arrow-left"
                                        wire:click="updateStatus({{ $openTask->id }}, 'In progress')" />
                                @else
                                    <x-mary-button label="Complete task" class="btn-primary btn-sm" icon-right="o-check"
                                        wire:click="updateStatus({{ $openTask->id }}, 'Done')" />
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </x-slot>
        @endif
    </x-mary-modal>

    <div class="grid grid-cols-3 gap-4 min-h-16 mb-14">
        <div class="space-y-2">
            <div class="flex justify-between w-full">
                <div class="flex items-center gap-1">
                    <x-mary-icon name="o-square-2-stack" class="text-primary" />
                    <p class="text-sm font-semibold uppercase mt-[2px]">Todo</p>
                </div>
                <p class="text-sm text-primary/75">{{ $todos->count() }} tasks</p>
            </div>
            <div class="flex flex-col h-full gap-4 p-4 border rounded-lg border-primary bg-primary/10">
                @if ($todos->isEmpty())
                    <p class="text-sm text-primary/75">No tasks to show</p>
                @else
                    @foreach ($todos as $task)
                        <div :key="$task - > id"
                            class="h-56 p-5 transition-all duration-300 border rounded-lg text-primary bg-base-200/90 border-primary/20 hover:border-primary/50 hover:shadow-lg shadow-black">
                            <div class="flex flex-col h-full">
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between w-full">
                                        <button wire:click="openModal({{ $task->id }})"
                                            class="text-xl font-semibold text-gray-300 transition-all duration-300 border-b-2 border-transparent cursor-pointer hover:border-gray-300">
                                            {{ $task->title }}
                                        </button>
                                        <div class="flex gap-1">
                                            <x-mary-button icon="o-chevron-right"
                                                class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50 text-primary"
                                                wire:click="updateStatus({{ $task->id }}, 'In progress')" />
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <p class="text-sm text-primary">
                                            {{ Str::limit($task->description, 100) }}
                                        </p>
                                        <a href="{{ $task->link }}" target="_blank"
                                            class="text-sm underline text-primary underline-offset-2">
                                            {{ Str::limit($task->link, 45) }}
                                        </a>
                                    </div>
                                </div>
                                <div class="flex items-end justify-between mt-auto">
                                    <p class="text-xs opacity-75">Due:
                                        {{ Carbon\Carbon::parse($task->due_date)->format('d.m.Y') }}</p>
                                    <div class="gap-2">
                                        <x-mary-button label="Complete" class="btn-primary btn-sm" icon-right="o-check"
                                            wire:click="updateStatus({{ $task->id }}, 'Done')" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="space-y-2">
            <div class="flex justify-between w-full">
                <div class="flex items-center gap-1">
                    <x-mary-icon name="o-puzzle-piece" class="text-primary" />
                    <p class="text-sm font-semibold uppercase mt-[2px]">In progress</p>
                </div>
                <p class="text-sm text-primary/75">{{ $inProgress->count() }} tasks</p>
            </div>

            <div class="flex flex-col h-full gap-4 p-4 border rounded-lg border-primary bg-primary/10">
                @if ($inProgress->isEmpty())
                    <p class="text-sm text-primary/75">No tasks to show</p>
                @else
                    @foreach ($inProgress as $task)
                        <div :key="$task - > id"
                            class="h-56 p-5 transition-all duration-300 border rounded-lg text-primary bg-base-200/90 border-primary/20 hover:border-primary/50 hover:shadow-lg shadow-black">
                            <div class="flex flex-col h-full">
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between w-full">
                                        <button wire:click="openModal({{ $task->id }})"
                                            class="text-xl font-semibold text-gray-300 transition-all duration-300 border-b-2 border-transparent cursor-pointer hover:border-gray-300">
                                            {{ $task->title }}
                                        </button>
                                        <div class="flex gap-1">
                                            <x-mary-button icon="o-chevron-left"
                                                class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50 text-primary"
                                                wire:click="updateStatus({{ $task->id }}, 'Todo' )" />

                                            <x-mary-button icon="o-chevron-right"
                                                class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50 text-primary"
                                                wire:click="updateStatus({{ $task->id }}, 'Waiting' )" />
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <p class="text-sm text-primary">
                                            {{ Str::limit($task->description, 100) }}
                                        </p>
                                        <a href="{{ $task->link }}" target="_blank"
                                            class="text-sm underline text-primary underline-offset-2">
                                            {{ Str::limit($task->link, 45) }}
                                        </a>
                                    </div>
                                </div>
                                <div class="flex items-end justify-between mt-auto">
                                    <p class="text-xs opacity-75">Due:
                                        {{ Carbon\Carbon::parse($task->due_date)->format('d.m.Y') }}</p>
                                    <div class="gap-2">
                                        <x-mary-button label="Complete" class="btn-primary btn-sm"
                                            icon-right="o-check"
                                            wire:click="updateStatus({{ $task->id }}, 'Done')" />

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="space-y-2">
            <div class="flex justify-between w-full">
                <div class="flex items-center gap-1">
                    <x-mary-icon name="o-clock" class="text-primary" />
                    <p class="text-sm font-semibold uppercase mt-[2px]">Waiting</p>
                </div>
                <p class="text-sm text-primary/75">{{ $waiting->count() }} tasks</p>
            </div>

            <div class="flex flex-col h-full gap-4 p-4 border rounded-lg border-primary bg-primary/10">
                @if ($waiting->isEmpty())
                    <p class="text-sm text-primary/75">No tasks to show</p>
                @else
                    @foreach ($waiting as $task)
                        <div :key="$task - > id"
                            class="h-56 p-5 transition-all duration-300 border rounded-lg text-primary bg-base-200/90 border-primary/20 hover:border-primary/50 hover:shadow-lg shadow-black">
                            <div class="flex flex-col h-full">
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between w-full">
                                        <button wire:click="openModal({{ $task->id }})"
                                            class="text-xl font-semibold text-gray-300 transition-all duration-300 border-b-2 border-transparent cursor-pointer hover:border-gray-300">
                                            {{ $task->title }}
                                        </button>
                                        <div class="flex gap-1">

                                            <x-mary-button icon="o-chevron-left"
                                                class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50 text-primary"
                                                wire:click="updateStatus({{ $task->id }}, 'In progress')" />

                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <p class="text-sm text-primary">
                                            {{ Str::limit($task->description, 100) }}
                                        </p>
                                        <a href="{{ $task->link }}" target="_blank"
                                            class="text-sm underline text-primary underline-offset-2">
                                            {{ Str::limit($task->link, 45) }}
                                        </a>
                                    </div>
                                </div>
                                <div class="flex items-end justify-between mt-auto">
                                    <p class="text-xs opacity-75">Due:
                                        {{ Carbon\Carbon::parse($task->due_date)->format('d.m.Y') }}</p>
                                    <div class="gap-2">
                                        <x-mary-button label="Complete" class="btn-primary btn-sm"
                                            icon-right="o-check"
                                            wire:click="updateStatus({{ $task->id }}, 'Done')" />

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="mt-auto space-y-2">
        <x-mary-collapse wire:model="showDoneTasks" class="rounded-lg border-primary bg-primary/10">
            <x-slot:heading wire:click="$toggle('showDoneTasks')">
                <div class="flex items-center gap-1 mt-[3px]">
                    <x-mary-icon name="o-check-badge" class="text-primary" />
                    <p class="text-sm font-semibold uppercase mt-[2px]">Done</p>
                </div>
            </x-slot:heading>
            <x-slot:content>
                <div class="">
                    @if ($done->isEmpty())
                        <p class="text-sm text-primary/75">No tasks to show</p>
                    @else
                        <p class="text-sm text-primary/75">{{ $done->count() }} tasks</p>
                        <div class="grid grid-cols-3 gap-4">
                            @foreach ($done as $task)
                                <div
                                    class="h-56 p-5 transition-all duration-300 border rounded-lg text-primary bg-base-200/90 border-primary/20 hover:border-primary/50 hover:shadow-lg shadow-black">
                                    <div class="flex flex-col h-full">
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between w-full">
                                                <button wire:click="openModal({{ $task->id }})"
                                                    class="text-xl font-semibold text-gray-300 transition-all duration-300 border-b-2 border-transparent cursor-pointer hover:border-gray-300">
                                                    {{ $task->title }}
                                                </button>
                                            </div>
                                            <div class="flex flex-col gap-2">
                                                <p class="text-sm text-primary">
                                                    {{ Str::limit($task->description, 100) }}
                                                </p>
                                                <a href="{{ $task->link }}" target="_blank"
                                                    class="text-sm underline text-primary underline-offset-2">
                                                    {{ Str::limit($task->link, 45) }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="flex items-end justify-between mt-auto">
                                            <p class="text-xs opacity-75">Due:
                                                {{ Carbon\Carbon::parse($task->due_date)->format('d.m.Y') }}</p>
                                            <div class="gap-2">
                                                <x-mary-button label="In progress" class="bg-base-300 btn-sm"
                                                    icon="o-arrow-left"
                                                    wire:click="updateStatus({{ $task->id }}, 'In progress')" />

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </x-slot:content>
        </x-mary-collapse>
    </div>
</div>
