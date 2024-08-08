<?php

use Livewire\Volt\Component;

new class extends Component {
    public bool $showDoneTasks = true;
    public bool $taskModal = false;
    public $openTask = null;

    protected $listeners = [
        'refreshTaskList' => '$refresh',
    ];

    public function with()
    {
        $tasks = Auth::user()->tasks()->latest()->get();
        $todoTasks = $tasks->where('status', 'Todo');
        $inProgressTasks = $tasks->where('status', 'In progress');
        $waitingTasks = $tasks->where('status', 'Waiting');
        $doneTasks = $tasks->where('status', 'Done');
        return [
            'todoTasks' => $todoTasks,
            'inProgressTasks' => $inProgressTasks,
            'waitingTasks' => $waitingTasks,
            'doneTasks' => $doneTasks,
        ];
    }

    public function updateStatus($id, $status)
    {
        $task = auth()->user()->tasks()->find($id);
        $task->status = $status;
        $task->save();
    }

    public function openModal($id)
    {
        $openTask = auth()->user()->tasks()->find($id);
        $this->openTask = $openTask;
        $this->taskModal = true;
    }
};

?>

<div class="flex flex-col">
    <x-mary-modal wire:model="taskModal" class="backdrop-blur">
        @if ($openTask)
            <x-slot name="slot" class="!text-black">
                <div class="flex items-start justify-between w-full mb-4">
                    <p class="text-2xl font-semibold text-gray-300">
                        {{ $openTask->title }}
                    </p>
                    <x-mary-button class="btn-sm btn-circle" icon="o-x-mark" @click="$wire.taskModal = false" />
                </div>
                <div class="flex flex-col gap-4">
                    <p>{{ $openTask->description }}</p>
                    <x-mary-button label="Complete task" class="self-end btn-primary btn-sm" icon-right="o-check"
                        wire:click="updateStatus({{ $openTask->id }}, 'Done')" />
                </div>
            </x-slot>
        @endif
    </x-mary-modal>

    <div class="grid grid-cols-3 gap-4 min-h-16 mb-14">
        <div class="space-y-2">
            <div class="flex items-center gap-1">
                <x-mary-icon name="o-square-2-stack" class="text-primary" />
                <p class="text-sm font-semibold uppercase mt-[2px]">Todo</p>
            </div>
            <div class="flex flex-col h-full gap-4 p-4 border rounded-lg border-primary bg-primary/10">
                @if ($todoTasks->isEmpty())
                    <p class="text-sm text-primary/75">No tasks to show</p>
                @else
                    @foreach ($todoTasks as $task)
                        <p class="text-sm text-primary/75">{{ $todoTasks->count() }} tasks</p>
                        <livewire:tasks.taskcard :task="$task" :key="$task->id" />
                    @endforeach
                @endif
            </div>
        </div>
        <div class="space-y-2">
            <div class="flex items-center gap-1">
                <x-mary-icon name="o-puzzle-piece" class="text-primary" />
                <p class="text-sm font-semibold uppercase mt-[2px]">In progress</p>
            </div>

            <div class="flex flex-col h-full gap-4 p-4 border rounded-lg border-primary bg-primary/10">
                @if ($inProgressTasks->isEmpty())
                    <p class="text-sm text-primary/75">No tasks to show</p>
                @else
                    <p class="text-sm text-primary/75">{{ $inProgressTasks->count() }} tasks</p>
                    @foreach ($inProgressTasks as $task)
                        <livewire:tasks.taskcard :task="$task" :key="$task->id" />
                    @endforeach
                @endif
            </div>
        </div>
        <div class="space-y-2">
            <div class="flex items-center gap-1">
                <x-mary-icon name="o-clock" class="text-primary" />
                <p class="text-sm font-semibold uppercase mt-[2px]">Waiting</p>
            </div>

            <div class="flex flex-col h-full gap-4 p-4 border rounded-lg border-primary bg-primary/10">
                @if ($waitingTasks->isEmpty())
                    <p class="text-sm text-primary/75">No tasks to show</p>
                @else
                    @foreach ($waitingTasks as $task)
                        <p class="text-sm text-primary/75">{{ $waitingTasks->count() }} tasks</p>
                        <livewire:tasks.taskcard :task="$task" :key="$task->id" />
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
                    @if ($doneTasks->isEmpty())
                        <p class="text-sm text-primary/75">No tasks to show</p>
                    @else
                        <p class="text-sm text-primary/75">{{ $doneTasks->count() }} tasks</p>
                        <div class="grid grid-cols-3 gap-4">
                            @foreach ($doneTasks as $task)
                                <livewire:tasks.taskcard :task="$task" :key="$task->id" />
                            @endforeach
                        </div>
                    @endif
                </div>
            </x-slot:content>
        </x-mary-collapse>


    </div>
</div>
