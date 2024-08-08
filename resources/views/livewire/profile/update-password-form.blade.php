<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-primary/75">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div>
            <x-mary-input wire:model="current_password" :label="__('Current Password')" id="update_password_current_password"
                name="current_password" type="password" autocomplete="current-password" />
        </div>

        <div>
            <x-mary-input wire:model="password" :label="__('New Password')" id="update_password_password" name="password"
                type="password" autocomplete="new-password" />
        </div>

        <div>
            <x-mary-input wire:model="password_confirmation" :label="__('Confirm Password')"
                id="update_password_password_confirmation" name="password_confirmation" type="password"
                autocomplete="new-password" />
        </div>

        <div class="flex items-center gap-4">
            <x-mary-button type="submit" class="btn-primary">{{ __('Save') }}</x-mary-button>

            <x-action-message class="me-3" on="password-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
