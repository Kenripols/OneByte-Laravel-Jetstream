<x-app-layout>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto space-y-8">

            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-8">

                <h1 class="text-3xl font-bold text-center text-[rgb(0,0,102)]">
                    Mascotas
                </h1>

                <p class="mt-3 text-gray-500 text-center text-lg leading-relaxed">
                    Administra Mascotas del sistema
                </p>

            </section>

            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6">

                @livewire('admin.pets-table')

            </section>

        </div>

    </div>

</x-app-layout>