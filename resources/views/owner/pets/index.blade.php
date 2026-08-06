<x-app-layout>
    <div class="py-12 bg-[#F5F8FF] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Encabezado -->
            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8">
                <h1 class="text-3xl font-bold text-[#000066] text-center">
                    Mis Mascotas
                </h1>

                <p class="mt-3 text-lg text-gray-500 text-center leading-relaxed max-w-3xl mx-auto">
                    Aquí podrás consultar la información de tus mascotas, mantener sus datos actualizados,
                    asociar un código QR y cambiar su estado cuando sea necesario.
                </p>
            </div>

            <!-- Botón -->
            {{-- <div>
                <a href="{{ route('owner.qrplates.create') }}"
                    class="inline-flex items-center rounded-xl border-2 border-[#000066] bg-white px-5 py-2.5 font-medium text-[#000066] transition hover:bg-[#F1F5F9]">
                    Asociar QR a Mascota
                </a>
            </div> --}}

            <!-- Contenido -->
            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-6 shadow-lg">
                @livewire('owner.pets-table')
            </div>

        </div>
    </div>
</x-app-layout>
