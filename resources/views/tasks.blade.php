<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Your tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="flex flex-col gap-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-wui-card>
                <x-slot name="title" class="!text-black">
                    Add a new task
                </x-slot>
                <x-slot name="slot" class="!text-black">
                    <form class="flex flex-col gap-4" wire:submit.prevent="create">
                        <div class="flex gap-6">
                            <div class="flex flex-col w-6/12 gap-4">
                                <x-wui-input label="Title" placeholder="Enter a title" required />
                                <x-wui-textarea label="Description" placeholder="Enter a description" />
                            </div>
                            <div class="flex flex-col w-6/12 gap-4">
                                <x-wui-input label="Link" placeholder="Link to a resource" />
                                <x-wui-datetime-picker label="Due Date" placeholder="Select a date"
                                    parse-format="DD-MM-YYYY" without-time="true" />
                            </div>
                        </div>
                        <x-wui-button type="submit" class="ml-auto">Create todo</x-wui-button>
                    </form>
                </x-slot>
            </x-wui-card>
            <livewire:tasks.show-tasks />
        </div>
    </div>
</x-app-layout>
