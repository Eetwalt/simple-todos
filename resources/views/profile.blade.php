<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto">
        <div class="space-y-6">
            <div class="p-4 shadow bg-base-200 sm:p-8 sm:rounded-lg">
                <livewire:profile.update-profile-information-form />
            </div>

            <div class="p-4 shadow bg-base-200 sm:p-8 sm:rounded-lg">
                <livewire:profile.update-password-form />
            </div>

            <div class="p-4 shadow bg-base-200 sm:p-8 sm:rounded-lg">
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </div>
</x-app-layout>
