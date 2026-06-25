<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Asociar Placa QR a Mascota') }}
        </h2>
    </x-slot>

    @if ($errors->any())
        <div class="mb-4">
            <ul class="text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(isset($qr))
        <div class="bg-green-100 p-3 mb-4 rounded">
            Estás asignando el QR:
            <strong>{{ $qr->code }}</strong>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if(!$qr)
                    <div class="bg-yellow-100 p-3 mb-4 rounded">
                        <p class="font-semibold">Solo leer un QR.</p>
                        <p class="text-sm text-gray-600">Acercá la placa o el código y esperá a que se detecte.</p>
                    </div>

                    <div class="mb-4" wire:ignore>
                        <label class="block text-gray-700 font-bold mb-2">Escanear QR con cámara:</label>
                        <div id="reader" style="width: 300px;"></div>
                        <div id="qr-result" class="mt-2 text-green-600 font-bold"></div>
                        <div id="qr-action" class="mt-4"></div>
                    </div>

                    @if(request()->has('qr'))
                        <div class="bg-red-100 p-3 rounded text-red-700">
                            No se encontró un QR válido con el código cargado.
                            <span class="font-semibold">{{ request()->query('qr') }}</span>
                        </div>
                    @endif
                @else
                    <form action="{{ route('owner.qrplates.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="pet_id" class="block text-gray-700 font-bold mb-2">Mascota:</label>
                            <select name="pet_id" id="pet_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Crear nueva mascota</option>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->id }}"
                                        data-name="{{ $pet->name }}"
                                        data-bdate="{{ $pet->bDate }}"
                                        data-breed="{{ $pet->breed_id }}">
                                        {{ $pet->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="new-pet-fields" class="mt-4 p-4 border rounded bg-gray-50">
                            <h3 class="font-bold mb-2">Nueva mascota</h3>

                            <input type="text" name="new_name" id="new_name" placeholder="Nombre"
                                class="border rounded w-full mb-2 p-2" required>

                            <input type="date" name="new_bDate" id="new_bDate"
                                class="border rounded w-full mb-2 p-2">

                            <select name="new_breed_id" id="new_breed_id" class="border rounded w-full mb-2 p-2" required>
                                <option value="">Seleccione raza</option>
                                @foreach($pets->first()?->breed?->all() ?? [] as $breed)
                                    <option value="{{ $breed->id }}">{{ $breed->breedName }}</option>
                                @endforeach
                            </select>

                            <input type="file" name="new_photo" id="new_photo" class="w-full">
                        </div>

                        <div class="mb-4">
                            <label for="iDate" class="block text-gray-700 font-bold mb-2">Fecha de Registro:</label>
                            <input type="date" name="iDate" id="iDate" value="{{ now()->format('Y-m-d') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="eDate" class="block text-gray-700 font-bold mb-2">Fecha de Vencimiento:</label>
                            <input type="date" name="eDate" id="eDate" value="{{ now()->addYears(2)->format('Y-m-d') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                        </div>

                        <input type="hidden" name="code" value="{{ $qr->code }}">

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Guardar
                        </button>
                    </form>
                @endif

            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @unless($qr)
                const qrResult = document.getElementById('qr-result');
                const qrAction = document.getElementById('qr-action');

                if (!qrResult || !qrAction) {
                    return;
                }

                const scanner = new Html5QrcodeScanner('reader', {
                    fps: 10,
                    qrbox: { width: 250, height: 250 }
                });

                scanner.render((decodedText) => {
                    let trimmed = decodedText.trim();

                    if (/^https?:\/\//i.test(trimmed)) {
                        try {
                            const url = new URL(trimmed);
                            const path = url.pathname.replace(/\/$/, '');
                            const matched = path.match(/\/qr\/(.+)$/);
                            if (matched) {
                                trimmed = matched[1];
                            }
                        } catch (e) {
                            // no es una URL válida, conservar el texto original
                        }
                    }

                    qrResult.textContent = `Código escaneado: ${trimmed}`;
                    scanner.clear();

                    const continueButton = document.createElement('button');
                    continueButton.type = 'button';
                    continueButton.className = 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded';
                    continueButton.textContent = 'Continuar con este QR';
                    continueButton.addEventListener('click', function () {
                        window.location.href = `/qr/${encodeURIComponent(trimmed)}`;
                    });

                    qrAction.innerHTML = '';
                    qrAction.appendChild(continueButton);
                }, (errorMessage) => {
                    // Ignorar errores de escaneo menores mientras busca un QR válido.
                });
            @endunless

            const petSelect = document.getElementById('pet_id');
            const newPetFields = document.getElementById('new-pet-fields');
            const newName = document.getElementById('new_name');
            const newBreed = document.getElementById('new_breed_id');
            const newPhoto = document.getElementById('new_photo');

            if (petSelect && newPetFields) {
                function toggleNewPetFields() {
                    const creatingNew = petSelect.value === '';

                    newPetFields.style.display = creatingNew ? 'block' : 'none';

                    [newName, newBreed, newPhoto].forEach((field) => {
                        if (!field) {
                            return;
                        }
                        field.disabled = !creatingNew;
                        if (!creatingNew) {
                            field.value = field.tagName.toLowerCase() === 'select' ? '' : field.value;
                        }
                    });

                    if (newBreed) {
                        newBreed.required = creatingNew;
                    }
                }

                petSelect.addEventListener('change', toggleNewPetFields);
                toggleNewPetFields();
            }
        });
    </script>
</x-app-layout>