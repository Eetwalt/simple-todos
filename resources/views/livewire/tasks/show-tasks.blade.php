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
};

?>

<div>

    <div class="grid grid-cols-3 gap-4">
        <div class="space-y-2">
            <p class="text-sm font-semibold text-gray-800 uppercase">Todo</p>
            <div class="flex flex-col gap-6 p-4 border border-gray-500 rounded-lg bg-slate-100">
                @foreach ($todoTasks as $task)
                    <x-wui-card wire:key="{{ $task->id }}">
                        <x-slot name="title" class="flex flex-col w-full gap-2">
                            <div class="flex items-center justify-between w-full">
                                @if ($task->due_date)
                                    <p class="text-xs text-gray-500">
                                        Due: {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                    </p>
                                @endif
                            </div>

                            <a href="#" class="text-sm font-bold text-gray-900 underline underline-offset-2">
                                {{ $task->title }}
                            </a>
                        </x-slot>
                        <x-slot name="slot" class="text-sm">
                            {{ $task->description }}
                        </x-slot>
                    </x-wui-card>
                @endforeach
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-sm font-semibold text-gray-800 uppercase">In progress</p>

            <div class="flex flex-col gap-6 p-4 bg-blue-100 border border-blue-500 rounded-lg">
                @foreach ($inProgressTasks as $task)
                    <x-wui-card wire:key="{{ $task->id }}">
                        <x-slot name="title" class="flex flex-col w-full gap-2">
                            <div class="flex items-center justify-between w-full">
                                @if ($task->due_date)
                                    <p class="text-xs text-gray-500">
                                        Due: {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                    </p>
                                @endif
                            </div>

                            <a href="#" class="text-sm font-bold text-gray-900 underline underline-offset-2">
                                {{ $task->title }}
                            </a>
                        </x-slot>
                        <x-slot name="slot" class="text-sm">
                            {{ $task->description }}
                        </x-slot>
                    </x-wui-card>
                @endforeach
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-sm font-semibold text-gray-800 uppercase">Waiting</p>

            <div class="flex flex-col gap-6 p-4 bg-yellow-100 border border-yellow-500 rounded-lg">
                @foreach ($waitingTasks as $task)
                    <x-wui-card wire:key="{{ $task->id }}">
                        <x-slot name="title" class="flex flex-col w-full gap-2">
                            <div class="flex items-center justify-between w-full">
                                @if ($task->due_date)
                                    <p class="text-xs text-gray-500">
                                        Due: {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                    </p>
                                @endif
                            </div>

                            <a href="#" class="text-sm font-bold text-gray-900 underline underline-offset-2">
                                {{ $task->title }}
                            </a>
                        </x-slot>
                        <x-slot name="slot" class="text-sm">
                            {{ $task->description }}
                        </x-slot>
                    </x-wui-card>
                @endforeach
            </div>
        </div>
    </div>
    <div class="mt-6 space-y-2">
        <p class="text-sm font-semibold text-gray-800 uppercase">Done</p>
        <div class="grid grid-cols-3 gap-6 p-4 bg-green-100 border border-green-500 rounded-lg">
            @foreach ($doneTasks as $task)
                <x-wui-card wire:key="{{ $task->id }}">
                    <x-slot name="title" class="flex flex-col w-full gap-2">
                        <div class="flex items-center justify-between w-full">
                            @if ($task->due_date)
                                <p class="text-xs text-gray-500">
                                    Due: {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                </p>
                            @endif
                        </div>

                        <a href="#" class="text-sm font-bold text-gray-900 underline underline-offset-2">
                            {{ $task->title }}
                        </a>
                    </x-slot>
                    <x-slot name="slot" class="text-sm">
                        {{ $task->description }}
                    </x-slot>
                </x-wui-card>
            @endforeach
        </div>
    </div>
</div>
