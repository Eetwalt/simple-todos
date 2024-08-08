<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    {{-- User --}}
    @if ($user = auth()->user())
        <x-mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="pt-2">
            <x-slot:actions>
                <x-mary-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate
                    wire:click="logout" />
            </x-slot:actions>
        </x-mary-list-item>
    @endif

    {{-- Activates the menu item when a route matches the `link` property --}}
    <x-mary-menu activate-by-route>
        <x-mary-menu-item title="Tasks" icon="o-document" link="/tasks" />
        <x-mary-menu-item title="Stats" icon="o-chart-bar" link="###" />
        <x-mary-menu-item title="Profile" icon="o-user" link="/profile" />
    </x-mary-menu>
</div>
