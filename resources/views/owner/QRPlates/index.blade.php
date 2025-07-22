<!-- Vista de PLACASQR de usuario OWNER -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Placas QR Asociadas') }}
        </h2>

    </x-slot>
    <!-- Muestro mensaje de error -->
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @role('owner')
       <!-- Boton de agregar mascota para owner -->
       <div class="block mb-8">
                <a href="{{ route('owner.qrplates.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Asociar QR a Mascota</a>
            </div>
            @endrole
       

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <!-- Nombre de columnas -->
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID QR</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código QR</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Registro </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Vencimiento</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Mascota Asociada</th>
                            
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($QRPlates as $QRPlate)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $QRPlate->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $QRPlate->code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $QRPlate->iDate }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $QRPlate->eDate }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $QRPlate->pet_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">

                                    <a href="{{ route('owner.qrplates.show', $QRPlate) }}" class="text-blue-600 hover:text-blue-900">Ver Detalles</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $QRPlates->links() }} <!-- Paginación -->
            </div>
        </div>
    </div>
</div>
    </x-app-layout>