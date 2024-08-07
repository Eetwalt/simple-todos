<?php

use Livewire\Volt\Component;

new class extends Component {
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
};

?>

<div class="flex flex-col h-full space-y-14">
    <div class="grid grid-cols-3 gap-4 min-h-16">
        <div class="space-y-2">
            <div class="flex items-center"></div>

            <p class="items-center text-sm font-semibold uppercase">
                <span>
                    <x-mary-icon name="o-square-2-stack" class="text-primary" />
                </span>
                Todo
            </p>
            <div class="flex flex-col h-full gap-4 p-4 border rounded-lg border-primary bg-primary/10">
                @if ($todoTasks->isEmpty())
                    <p class="text-sm text-primary/75">No tasks to show</p>
                @else
                    @foreach ($todoTasks as $task)
                        <p class="text-sm text-primary/75">{{ $todoTasks->count() }} tasks</p>
                        <x-mary-card class="text-primary" :key="$task->id" title="{{ $task->title }}"
                            subtitle="{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}">
                            <div class="flex flex-col gap-2">
                                {{ $task->description }}
                                <x-mary-button label="Complete" class="self-end btn-primary btn-sm" icon-right="o-check"
                                    wire:click="updateStatus({{ $task->id }}, 'Done')" />
                            </div>
                            <x-slot:menu class="self-start">
                                @if ($task->status === 'Todo')
                                    <x-mary-button icon="o-chevron-right"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'In progress')" />
                                @elseif ($task->status === 'In progress')
                                    <x-mary-button icon="o-chevron-left"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'Todo')" />
                                    <x-mary-button icon="o-chevron-right"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'Waiting')" />
                                @elseif ($task->status === 'Waiting')
                                    <x-mary-button icon="o-chevron-left"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'In progress')" />
                                @endif

                            </x-slot:menu>
                        </x-mary-card>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-sm font-semibold uppercase">In progress</p>

            <div class="flex flex-col h-full gap-4 p-4 border rounded-lg border-primary bg-primary/10">
                @if ($inProgressTasks->isEmpty())
                    <p class="text-sm text-primary/75">No tasks to show</p>
                @else
                    <p class="text-sm text-primary/75">{{ $inProgressTasks->count() }} tasks</p>
                    @foreach ($inProgressTasks as $task)
                        <x-mary-card class="text-primary" :key="$task->id" title="{{ $task->title }}"
                            subtitle="{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}">
                            <div class="flex flex-col gap-2">
                                {{ $task->description }}
                                <x-mary-button label="Complete" class="self-end btn-primary btn-sm" icon-right="o-check"
                                    wire:click="updateStatus({{ $task->id }}, 'Done')" />
                            </div>
                            <x-slot:menu class="self-start">
                                @if ($task->status === 'Todo')
                                    <x-mary-button icon="o-chevron-right"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'In progress')" />
                                @elseif ($task->status === 'In progress')
                                    <x-mary-button icon="o-chevron-left"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'Todo')" />
                                    <x-mary-button icon="o-chevron-right"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'Waiting')" />
                                @elseif ($task->status === 'Waiting')
                                    <x-mary-button icon="o-chevron-left"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'In progress')" />
                                @endif

                            </x-slot:menu>
                        </x-mary-card>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-sm font-semibold uppercase"">Waiting</p>

            <div class="flex flex-col h-full gap-4 p-4 border rounded-lg border-primary bg-primary/10">
                @if ($waitingTasks->isEmpty())
                    <p class="text-sm text-primary/75">No tasks to show</p>
                @else
                    @foreach ($waitingTasks as $task)
                        <p class="text-sm text-primary/75">{{ $waitingTasks->count() }} tasks</p>
                        <x-mary-card class="text-primary" :key="$task->id" title="{{ $task->title }}"
                            subtitle="{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}">
                            <div class="flex flex-col gap-2">
                                {{ $task->description }}
                                <x-mary-button label="Complete" class="self-end btn-primary btn-sm" icon-right="o-check"
                                    wire:click="updateStatus({{ $task->id }}, 'Done')" />
                            </div>
                            <x-slot:menu class="self-start">
                                @if ($task->status === 'Todo')
                                    <x-mary-button icon="o-chevron-right"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'In progress')" />
                                @elseif ($task->status === 'In progress')
                                    <x-mary-button icon="o-chevron-left"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'Todo')" />
                                    <x-mary-button icon="o-chevron-right"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'Waiting')" />
                                @elseif ($task->status === 'Waiting')
                                    <x-mary-button icon="o-chevron-left"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'In progress')" />
                                @endif

                            </x-slot:menu>
                        </x-mary-card>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="mt-auto space-y-2">
        <p class="text-sm font-semibold uppercase">Done</p>
        <div class="p-4 space-y-2 border rounded-lg border-primary bg-primary/10">
            @if ($doneTasks->isEmpty())
                <p class="text-sm text-primary/75">No tasks to show</p>
            @else
                <p class="text-sm text-primary/75">{{ $doneTasks->count() }} tasks</p>
                <div class="grid grid-cols-3 gap-4">
                    @foreach ($doneTasks as $task)
                        <x-mary-card class="text-primary" :key="$task->id" title="{{ $task->title }}"
                            subtitle="{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}">
                            <div class="flex flex-col gap-2">
                                {{ $task->description }}
                                <x-mary-button label="In progress" class="self-end btn-sm" icon="o-arrow-left"
                                    wire:click="updateStatus({{ $task->id }}, 'In progress')" />
                            </div>
                            <x-slot:menu class="self-start">
                                @if ($task->status === 'Todo')
                                    <x-mary-button icon="o-chevron-right"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'In progress')" />
                                @elseif ($task->status === 'In progress')
                                    <x-mary-button icon="o-chevron-left"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'Todo')" />
                                    <x-mary-button icon="o-chevron-right"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'Waiting')" />
                                @elseif ($task->status === 'Waiting')
                                    <x-mary-button icon="o-chevron-left"
                                        class="btn-circle btn-sm btn-outline border-primary hover:bg-primary/50"
                                        wire:click="updateStatus({{ $task->id }}, 'In progress')" />
                                @endif

                            </x-slot:menu>
                        </x-mary-card>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
