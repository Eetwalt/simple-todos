<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Your tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="flex flex-col gap-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-wui-button label="Open" wire:click="$openModal('simpleModal')" primary />

            <livewire:tasks.create-task />
            <livewire:tasks.show-tasks />
        </div>
    </div>

    <x-wui-modal name="simpleModal" persistent>
        <x-wui-card title="Consent Terms">
            <p>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                the
                industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                type
                and scrambled it to make a type specimen book. It has survived not only five centuries, but also
                the
                leap into electronic typesetting, remaining essentially unchanged. It was popularised in the
                1960s
                with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
                desktop
                publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            </p>

            <x-slot name="footer" class="flex justify-end gap-x-4">
                <x-wui-button flat label="Cancel" x-on:click="close" />

                <x-wui-button primary label="I Agree" wire:click="agree" />
            </x-slot>
        </x-wui-card>
    </x-wui-modal>
</x-app-layout>
