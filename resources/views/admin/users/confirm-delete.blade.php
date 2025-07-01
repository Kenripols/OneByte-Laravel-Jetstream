<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Confirmar eliminación
        </h2>
    </x-slot>

    <div class="p-6 bg-white rounded shadow space-y-4">
        <p>¿Seguro que quieres eliminar al usuario <strong>{{ $user->name }}</strong>?</p>

        <div class="flex space-x-4">
            <!-- Borrado lógico -->
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded"
                    onclick="return confirm('¿Confirmas el borrado lógico del usuario?')"
                >
                    Borrado Lógico
                </button>
            </form>

            <!-- Borrado definitivo -->
            <form action="{{ route('admin.users.force-delete', $user) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="bg-red-600 hover:bg-red-800 text-white py-2 px-4 rounded"
                    onclick="return confirm('¡Atención! Este borrado es definitivo. ¿Confirmas?')"
                >
                    Borrado Definitivo
                </button>
            </form>

            <a href="{{ route('admin.users.index') }}" class="bg-gray-400 hover:bg-gray-600 text-white py-2 px-4 rounded">
                Cancelar
            </a>
        </div>
    </div>
</x-app-layout>
