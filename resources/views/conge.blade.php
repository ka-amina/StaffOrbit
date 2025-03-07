<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('congés') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <livewire:conge />
    </div>
</x-app-layout>
