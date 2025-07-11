<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Editar Propietario') }}</h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Perfil de Propietario</h1>

        {{-- Mensajes de éxito --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Errores de validación --}}
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $owner = $user->owner ?? new \App\Models\Owner();
        @endphp

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <p><strong>Nro de Usuario:</strong> {{ $user->id }}</p>
            </div>
            <div class="mb-4">
                <p><strong>Nombre de Usuario:</strong> {{ $user->name }}</p>
            </div>
            <div class="mb-4">
                <p><strong>Email:</strong> {{ $user->email }}</p>
            </div>

            {{-- Datos del Owner --}}
            <div class="mb-4">
                <label for="docType" class="block text-gray-700 font-bold mb-2">Tipo de documento:</label>
                <select name="docType" id="docType" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="Cedula" {{ old('docType', $owner->docType ?? '') == "Cedula" ? 'selected' : '' }}>Cédula</option>
                    <option value="Pasaporte" {{ old('docType', $owner->docType ?? '') == "Pasaporte" ? 'selected' : '' }}>Pasaporte</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="docNum" class="block text-gray-700 font-bold mb-2">Número de documento:</label>
                <input type="number" name="docNum" id="docNum" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('docNum', $owner->docNum ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label for="fName1" class="block text-gray-700 font-bold mb-2">Primer Nombre:</label>
                <input type="text" name="fName1" id="fName1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('fName1', $owner->fName1 ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label for="fName2" class="block text-gray-700 font-bold mb-2">Segundo Nombre:</label>
                <input type="text" name="fName2" id="fName2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('fName2', $owner->fName2 ?? '') }}">
            </div>

            <div class="mb-4">
                <label for="sName1" class="block text-gray-700 font-bold mb-2">Primer Apellido:</label>
                <input type="text" name="sName1" id="sName1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('sName1', $owner->sName1 ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label for="sName2" class="block text-gray-700 font-bold mb-2">Segundo Apellido:</label>
                <input type="text" name="sName2" id="sName2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('sname2', $owner->sname2 ?? '') }}">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Actualizar Propietario
                </button>
            </div>
            <div class="mb-4">
                <a href="{{ route('admin.users.index') }}" 
                class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Volver</a>
            </div>
        </form>
    </div>
</x-app-layout>
