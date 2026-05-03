@if(session()->has('message'))
    <div class="bg-green-100 text-green-700 p-2 rounded">
        {{ session('message') }}
    </div>
@endif
<div>
    <!-- Filtros -->
    <div class="flex space-x-4 mb-4">
        <input type="text" wire:model.live="searchId" placeholder="Buscar por ID" class="border p-2" />
        <input type="text" wire:model.live="searchEmail" placeholder="Buscar por email" class="border p-2" />
        <!-- Botón para ver usuarios borrados lógicamente -->
            <a href="{{ route('admin.users.trashed') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Ver Usuarios Eliminados
            </a>
        
    </div>

    <!-- Tabla -->
    <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
        <thead class="bg-gray-100">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo Electrónico</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Creación</th>           
        </tr>
        </thead>
       <tbody>
    @forelse ($users as $user)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">
                {{ $user->id }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                {{ $user->email }}
            </td>

            <td class="px-6 py-4 whitespace-nowrap">
                {{ $user->created_at->format('d/m/Y') }}
            </td>

            <td class="px-6 py-4 whitespace-nowrap">
                <button wire:click="openModal({{ $user->id }})"
                        class="text-blue-600 hover:text-blue-900">
                    Ver Datos
                </button>
            </td>
            <td>
                <button wire:click="openEditModal({{ $user->id }})"
        class="text-yellow-600 hover:text-yellow-900">
    Editar
</button>   
            </td>
            <td>
<button wire:click="openDeleteModal({{ $user->id }})" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded"> Eliminar </button>
            </td>
            
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center py-4">No se encontraron usuarios</td>
        </tr>
    @endforelse
</tbody>
    </table>
    <div class="mt-4">
        {{ $users->links() }}
    </div>
@if($showModal && $selectedUser)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
        <h2 class="text-xl font-bold mb-2">{{ $selectedUser->owner?->fName1 }}</h2>
        <p><strong>ID:</strong> {{ $selectedUser->id }}</p>
        <p><strong>Correo Electrónico:</strong> {{ $selectedUser->email }}</p>
        <p><strong>Fecha de Creación:</strong> {{ $selectedUser->created_at->format('d/m/Y') }}</p>

@if($selectedUser->owner)
    <p><strong>Nombre Completo:</strong> {{ $selectedUser->owner->fName1 }} {{ $selectedUser->owner->fName2 }} {{$selectedUser->owner->sName1}} {{ $selectedUser->owner->sName2 }}</p>
    
    <p>
        <strong>Email:</strong>
        <a href="mailto:{{ $selectedUser->owner?->user?->email }}" class="text-blue-600 hover:underline">
            {{ $selectedUser->owner?->user?->email ?? 'No disponible' }}
        </a>
    </p>
    <p>
        <strong>Teléfono:</strong>
        <a href="https://wa.me/598{{ $selectedUser->owner?->user?->phone }}" target="_blank" class="text-green-600 hover:underline">
            {{ $selectedUser->owner?->user?->phone ?? 'No disponible' }}
        </a>
    </p>
    <p><strong>Tipo de Documento:</strong> {{ $selectedUser->owner->docType == 1 ? 'Cédula' : 'Pasaporte' }}</p>
    <p><strong>Número de Documento:</strong> {{ $selectedUser->owner->docNum }}</p>

@else
    <p><strong>Dueño:</strong> Este usuario no está registrado como dueño</p>
@endif
@if($selectedUser->owner?->pets?->count())
    <div class="mt-4">
        <h3 class="font-bold mb-2">Mascotas</h3>

        <ul class="list-disc pl-5 space-y-1">
            @foreach($selectedUser->owner->pets as $pet)
                <li>
                    <button
                        wire:click="openPetFromUser({{ $pet->id }})"
                        class="text-blue-600 hover:underline">
                        {{ $pet->name }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
@elseif($selectedUser->owner)
    <p class="mt-4 text-gray-500">Este propietario no tiene mascotas registradas.</p>
@endif
        <button wire:click="closeModal"
                class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
            Cerrar
        </button>
    </div>
</div>
@endif



@if($showEditModal)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-[500px] shadow-lg">
        <h2 class="text-xl font-bold mb-4">Editar usuario</h2>

        <div class="space-y-3">
            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" wire:model="editEmail" class="border p-2 w-full rounded">
                @error('editEmail') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Teléfono</label>
                <input type="text" wire:model="editPhone" class="border p-2 w-full rounded">
                @error('editPhone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
    <label class="block text-sm font-medium">Tipo de documento</label>
    <select wire:model="editDocType" class="border p-2 w-full rounded">
        <option value="">Seleccione...</option>
        <option value="1">Cédula</option>
        <option value="2">Pasaporte</option>
    </select>
    @error('editDocType') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
</div>

<div>
    <label class="block text-sm font-medium">Número de documento</label>
    <input type="number" wire:model="editDocNum" class="border p-2 w-full rounded">
    @error('editDocNum') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
</div>
            <div>
                <label class="block text-sm font-medium">Primer nombre</label>
                <input type="text" wire:model="editFName1" class="border p-2 w-full rounded">
            </div>

            <div>
                <label class="block text-sm font-medium">Segundo nombre</label>
                <input type="text" wire:model="editFName2" class="border p-2 w-full rounded">
            </div>

            <div>
                <label class="block text-sm font-medium">Primer apellido</label>
                <input type="text" wire:model="editSName1" class="border p-2 w-full rounded">
            </div>

            <div>
                <label class="block text-sm font-medium">Segundo apellido</label>
                <input type="text" wire:model="editSName2" class="border p-2 w-full rounded">
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-5">
            <button wire:click="closeEditModal"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Cancelar
            </button>

            <button wire:click="updateUser"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Guardar
            </button>
        </div>
    </div>
</div>
@endif

@if($showDeleteModal)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-[400px] shadow-lg space-y-4">

        <h2 class="text-xl font-bold text-gray-800">
            Confirmar eliminación
        </h2>

        <p>
            ¿Seguro que quieres eliminar al usuario
            <strong>{{ $deleteUserEmail }}</strong>?
        </p>

        <div class="flex gap-3 justify-end">

            <!-- Borrado lógico -->
            <button
                wire:click="deleteUser"
                class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded">
                Borrado lógico
            </button>
            <!-- No se hace borrado físico -->
            <!-- Cancelar -->
            <button
                wire:click="closeDeleteModal"
                class="bg-gray-400 hover:bg-gray-600 text-white py-2 px-4 rounded">
                Cancelar
            </button>

        </div>
    </div>
</div>
@endif
</div>

