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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('owner.qrplates.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="pet_id" class="block text-gray-700 font-bold mb-2">Mascota:</label>
                        <select name="pet_id" id="pet_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="">Seleccione una mascota</option>
                            @foreach($pets as $pet)
                                <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                            @endforeach
                        </select>
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
                    
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Guardar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>