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
                <label for="doctype" class="block text-gray-700 font-bold mb-2">Tipo de documento:</label>
                <select name="doctype" id="doctype" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="Cedula" {{ old('doctype', $owner->doctype ?? '') == "Cedula" ? 'selected' : '' }}>Cédula</option>
                    <option value="Pasaporte" {{ old('doctype', $owner->doctype ?? '') == "Pasaporte" ? 'selected' : '' }}>Pasaporte</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="docnum" class="block text-gray-700 font-bold mb-2">Número de documento:</label>
                <input type="number" name="docnum" id="docnum" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('docnum', $owner->docnum ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label for="fname" class="block text-gray-700 font-bold mb-2">Primer Nombre:</label>
                <input type="text" name="fname" id="fname" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('fname', $owner->fname ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label for="fname2" class="block text-gray-700 font-bold mb-2">Segundo Nombre:</label>
                <input type="text" name="fname2" id="fname2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('fname2', $owner->fname2 ?? '') }}">
            </div>

            <div class="mb-4">
                <label for="sname1" class="block text-gray-700 font-bold mb-2">Primer Apellido:</label>
                <input type="text" name="sname1" id="sname1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('sname1', $owner->sname1 ?? '') }}" required>
            </div>

            <div class="mb-4">
                <label for="sname2" class="block text-gray-700 font-bold mb-2">Segundo Apellido:</label>
                <input type="text" name="sname2" id="sname2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
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
