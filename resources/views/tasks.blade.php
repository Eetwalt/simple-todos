<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Your tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="flex flex-col gap-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <livewire:tasks.create-task />
            <livewire:tasks.show-tasks />
        </div>
    </div>
</x-app-layout>
