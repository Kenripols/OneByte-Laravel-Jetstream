<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuarios Eliminados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <table class="min-w-full divide-y divide-gray-200">
                   <thead>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Fecha de Eliminación</th>
        <th>Acciones</th> {{-- Nueva columna --}}
    </tr>
</thead>
<tbody>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->deleted_at->format('d/m/Y H:i') }}</td>
           <td>
    <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de restaurar este usuario?')">
        @csrf
        @method('PATCH')
        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-semibold py-1 px-3 rounded">
            Restaurar
        </button>
    </form>
</td>
        </tr>
    @endforeach
</tbody>
                </table>

                {{ $users->links() }}

            </div>
        </div>
    </div>
</x-app-layout>
