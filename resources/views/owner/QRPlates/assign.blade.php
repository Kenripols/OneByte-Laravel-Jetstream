<x-app-layout>
    <div class="max-w-xl mx-auto p-6">

        <h1 class="text-2xl font-bold mb-6">
            Asociar QR a una mascota
        </h1>

        @if($pets->count())

            <form method="POST" action="{{ route('owner.qrplates.store') }}">
                @csrf

                <!-- Seleccionar mascota -->
                <div class="mb-4">
                    <label class="block font-bold mb-2">Elegir mascota</label>

                    <select name="pet_id" class="w-full border rounded p-2">
                        @foreach($pets as $pet)
                            <option value="{{ $pet->id }}">
                                {{ $pet->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- QR oculto -->
                <input type="hidden" name="qr_id" value="{{ session('claimed_qr_id') }}">

                <button class="bg-blue-500 text-white px-4 py-2 rounded">
                    Asociar
                </button>
            </form>

            <hr class="my-6">

        @endif

        <!-- Crear nueva mascota -->
        <h2 class="text-xl font-bold mb-4">O crear nueva mascota</h2>

        <form method="POST" action="{{ route('owner.pets.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block font-bold mb-2">Nombre</label>
                <input type="text" name="name" class="w-full border rounded p-2" required>
            </div>

            <button class="bg-green-500 text-white px-4 py-2 rounded">
                Crear y asociar
            </button>
        </form>

    </div>
</x-app-layout>