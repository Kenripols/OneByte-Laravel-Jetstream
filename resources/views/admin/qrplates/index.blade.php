<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Generar QR
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-4">
@if (session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
        {{ session('error') }}
    </div>
@endif
                <form method="POST" action="{{ route('admin.qrplates.generate') }}">
                    @csrf

                    <input type="number" name="amount" min="1" required class="border p-1 w-20" />
                    <button type="submit" class="btn btn-primary">
                        Generar QR
                    </button>
                    <button type="submit" formaction="{{ route('admin.qrplates.download') }}">
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