<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Generar QR
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-4">

                <form method="POST" action="{{ route('admin.qrplates.generate') }}">
                    @csrf

                   <input type="number"  name="amount" wire:model="amount" min="1" class="border p-1 w-20" />
                    <button type="submit" class="btn btn-primary">
                        Generar QR
                    </button>
                   <button type="submit" formaction="{{ route('admin.qrplates.download') }}"                    >
                        Descargar lote
                    </button>
                </form>

            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-4">

                @livewire('admin.batch-viewer')

            </div>
        </div>
    </div>
</x-app-layout>