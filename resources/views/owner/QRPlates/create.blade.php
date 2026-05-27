<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Asociar Placa QR a Mascota') }}
        </h2>
    </x-slot>
    <!-- Muestro errores -->
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
                    Primero escaneá un QR para poder asociarlo
                </div>
            @endif
                <form action="{{ route('owner.qrplates.store') }}" method="POST">
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

                        <input type="text" name="new_name" placeholder="Nombre"
                            class="border rounded w-full mb-2 p-2">

                        <input type="date" name="new_bDate"
                            class="border rounded w-full mb-2 p-2">

                        <select name="new_breed_id" class="border rounded w-full mb-2 p-2">
                            <option value="">Seleccione raza</option>
                            @foreach($pets->first()?->breed?->all() ?? [] as $breed)
                                <option value="{{ $breed->id }}">{{ $breed->breedName }}</option>
                            @endforeach
                        </select>

                        <input type="file" name="new_photo" class="w-full">
                    </div>

                    <!-- Campo con fecha de registro actual no editable -->
                    
                    <div class="mb-4">
                        <label for="iDate" class="block text-gray-700 font-bold mb-2">Fecha de Registro:</label>
                        <input type="date" name="iDate" id="iDate" value="{{ now()->format('Y-m-d') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                    </div>
                    <!-- Campo con fecha de vencimiento sumandole 2 años a la fecha de registro no editable -->
                    
                    <div class="mb-4">
                        <label for="eDate" class="block text-gray-700 font-bold mb-2">Fecha de Vencimiento:</label>
                        <input type="date" name="eDate" id="eDate" value="{{ now()->addYears(2)->format('Y-m-d') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
                    </div>

                    <!-- Muestro codigo de QR -->
                    <!-- Escáner de QR -->
                    @if(!$qr)
                        <div class="mb-4" wire:ignore>
                            <label class="block text-gray-700 font-bold mb-2">Escanear QR con Cámara:</label>
                            <div id="reader" style="width: 300px;"></div>
                            <div id="qr-result" class="mt-2 text-green-600 font-bold"></div>
                        </div>
                        <input type="hidden" name="code" id="code"><!-- Campo oculto donde se guarda el resultado del QR -->
                    @else
                        <input type="hidden" name="code" value="{{ $qr->code }}">
@endif
                     
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    @if(!$qr) disabled style="opacity:0.5; cursor:not-allowed;" @endif>
                    Guardar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
        @if(!$qr) //vine hasta aca por una lectura de QR no quiero esta camara universal Quantica todo poderosa, porque ya tengo un codigo
            if (document.getElementById('reader')) {
                const scanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
                scanner.render((decodedText, decodedResult) => {// Mostrar el resultado
                    document.getElementById('qr-result').textContent = `Código escaneado: ${decodedText}`;
                    document.getElementById('code').value = decodedText;// Guardarlo en el campo oculto del formulario
                    scanner.clear();// Opcional: detener escáner
                });
            }
        @endif
        });
    </script>

    <script> //si elegis mascota todo bien, sino creas una nueva
    document.addEventListener("DOMContentLoaded", function () {

        const petSelect = document.getElementById('pet_id');
        const newPet = document.getElementById('new-pet-fields');

        function togglePetMode() {
            const disabled = petSelect.value !== "";

            newPet.style.opacity = disabled ? "0.5" : "1";

            newPet.querySelectorAll('input, select').forEach(el => {
                el.disabled = disabled;
            });
        }

        petSelect.addEventListener('change', togglePetMode);
        togglePetMode();

    });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {

        const petSelect = document.getElementById('pet_id');

        const nameInput = document.getElementById('new_name');
        const bdateInput = document.getElementById('new_bDate');
        const breedSelect = document.getElementById('new_breed_id');

        function updatePetFields() {
            const selected = petSelect.options[petSelect.selectedIndex];

            if (petSelect.value) {
                // llenar datos
                nameInput.value = selected.dataset.name || '';
                bdateInput.value = selected.dataset.bdate || '';
                breedSelect.value = selected.dataset.breed || '';

                // bloquear
                [nameInput, bdateInput, breedSelect].forEach(el => el.disabled = true);
            } else {
                // limpiar
                nameInput.value = '';
                bdateInput.value = '';
                breedSelect.value = '';

                // habilitar
                [nameInput, bdateInput, breedSelect].forEach(el => el.disabled = false);
            }
        }

        petSelect.addEventListener('change', updatePetFields);
        updatePetFields();

    });
    </script>

</x-app-layout>