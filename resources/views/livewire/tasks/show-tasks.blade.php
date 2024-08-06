<?php

use Livewire\Volt\Component;

new class extends Component {
    public function with()
    {
        return [
            'tasks' => Auth::user()
            ->tasks()
            ->orderBy('due_date', 'desc')
            ->get(),
        ];
    }
};

?>


<div class="grid grid-cols-3 gap-4">
    @foreach ($tasks as $task)
        <x-wui-card>
            <x-slot name="title">
                {{ $task->title }}
            </x-slot>
            <x-slot name="slot">
                {{ $task->description }}
            </x-slot>
        </x-wui-card>
    @endforeach
</div>
