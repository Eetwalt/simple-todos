<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Your tasks') }}
        </h2>
    </x-slot>


    <div class="flex flex-col h-full gap-6">
        <livewire:tasks.create-task />
        <livewire:tasks.show-tasks />
    </div>
</x-app-layout>
