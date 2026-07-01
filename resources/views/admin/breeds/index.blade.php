<x-app-layout>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Encabezado -->
            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-8">

                <h1 class="text-3xl font-bold text-center text-[#000066]">
                    Razas
                </h1>

                <p class="mt-3 text-gray-500 text-center text-lg leading-relaxed">
                    Administra Especies y Razas del sistema
                </p>

            </section>

            <!-- Contenido -->
            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-6">

                <!-- Botón agregar -->
                <div class="flex justify-end mb-6">

                    <a href="{{ route('admin.breeds.create') }}"
                        class="w-full sm:w-56 inline-flex items-center justify-center
                               px-4 py-2
                               bg-white
                               text-[#000066]
                               border-2 border-[#000066]
                               rounded-xl
                               font-semibold
                               hover:bg-[#F1F5F9]
                               transition">

                        Agregar Raza

                    </a>

                </div>

                <!-- Tabla -->
                <div class="border-2 border-[#000066] rounded-2xl overflow-hidden">

                    <div class="overflow-x-auto">

                        <table class="min-w-[850px] w-full divide-y divide-gray-200">

                            <thead class="bg-[#F1F5F9] border-b-2 border-[#000066]">

                                <tr>

                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                                        ID
                                    </th>

                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                                        Especie
                                    </th>

                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                                        Raza
                                    </th>

                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider">
                                        Tamaño
                                    </th>

                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-[11px] sm:text-xs font-semibold text-[#000066] uppercase tracking-wider w-64">
                                        Acciones
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-gray-200">

                                @foreach ($breeds as $breed)

                                    <tr class="hover:bg-[#F8FAFC] transition-all duration-200">

                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm">
                                            {{ $breed->id }}
                                        </td>

                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm">
                                            {{ $breed->animalType }}
                                        </td>

                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm">
                                            {{ $breed->breedName }}
                                        </td>

                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm">
                                            {{ $breed->size }}
                                        </td>

                                        <td class="px-3 sm:px-6 py-3 sm:py-4">

                                            <div class="flex justify-center gap-3">

                                                <a href="{{ route('admin.breeds.edit', $breed) }}"
                                                   class="w-20 sm:w-24
                                                          text-center
                                                          px-2 sm:px-3
                                                          py-1
                                                          text-xs sm:text-sm
                                                          border-2 border-[#000066]
                                                          text-[#000066]
                                                          rounded-lg
                                                          hover:bg-[#F1F5F9]
                                                          transition">

                                                    Editar

                                                </a>

                                                @if ($breed->pets_count > 0)
                                                    <span class="w-20 sm:w-24
                                                                 text-center
                                                                 px-2 sm:px-3
                                                                 py-1
                                                                 text-xs sm:text-sm
                                                                 border-2 border-gray-300
                                                                 text-gray-400
                                                                 rounded-lg
                                                                 cursor-not-allowed
                                                                 inline-block"
                                                          title="Esta raza tiene {{ $breed->pets_count }} mascota(s) asignada(s)">
                                                        Eliminar
                                                    </span>
                                                @else
                                                    <a href="{{ route('admin.breeds.drop', $breed) }}"
                                                       class="w-20 sm:w-24
                                                              text-center
                                                              px-2 sm:px-3
                                                              py-1
                                                              text-xs sm:text-sm
                                                              border-2 border-[#000066]
                                                              text-[#000066]
                                                              rounded-lg
                                                              hover:bg-[#ff5555]
                                                              transition">
                                                        Eliminar
                                                    </a>
                                                @endif

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

                <!-- Paginación -->
                <div class="mt-6 border-2 border-[#000066] rounded-2xl p-4 bg-[#F8FAFC]">

                    {{ $breeds->links() }}

                </div>

            </section>

        </div>

    </div>

</x-app-layout>