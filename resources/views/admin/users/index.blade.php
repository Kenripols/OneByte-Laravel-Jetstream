<x-app-layout>
    <!-- Opté por no utilizar el x-slot name='header' para poder utilizar un encabezado
    mas acorde al que venimos utilizando y porque me pareció mas fácil así sin tanto
    llamar cosas de otro lado -->
    <!-- <x-slot name="header">
        <h2 class="text-3xl text-center font-bold text-[#000066]">
        Usuarios
        </h2>
    </x-slot> -->

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto space-y-8">

            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-8">

                <h1 class="text-3xl font-bold text-center text-[#000066]">
                    Usuarios
                </h1>

                <p class="mt-3 text-gray-500 text-center text-lg leading-relaxed">
                    Administra Usuarios del Sistema
                </p>

            </section>

            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6">

                @livewire('admin.users-table')

            </section>

        </div>

    </div>

    <livewire:pet-viewer-modal />
</x-app-layout>