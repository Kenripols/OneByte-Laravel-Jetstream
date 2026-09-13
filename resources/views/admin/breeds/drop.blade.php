<x-app-layout>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-3xl mx-auto space-y-8">

            <!-- Encabezado -->
            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-8">

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-center text-[#000066]">
                    Eliminar Raza
                </h1>

                <p class="mt-3 text-gray-500 text-center text-base sm:text-lg lg:text-xl leading-relaxed">
                    Confirmar la eliminación de la raza seleccionada.
                </p>

            </section>

            <!-- Información de la raza -->
            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-8 shadow-sm">

                <form action="{{ route('admin.breeds.destroy', $breed) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <!-- Animal -->
                    <div class="mb-6">
                        <label
                            class="block text-[11px] sm:text-xs font-semibold text-[#000066] mb-2">
                            Tipo de Animal
                        </label>

                        <div class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2
                                    text-xs sm:text-sm text-gray-700">
                            {{ $breed->animalType }}
                        </div>
                    </div>

                    <!-- Nombre -->
                    <div class="mb-6">
                        <label
                            class="block text-[11px] sm:text-xs font-semibold text-[#000066] mb-2">
                            Nombre de la Raza
                        </label>

                        <div class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2
                                    text-xs sm:text-sm text-gray-700">
                            {{ $breed->breedName }}
                        </div>
                    </div>

                    <!-- Tamaño -->
                    <div class="mb-8">
                        <label
                            class="block text-[11px] sm:text-xs font-semibold text-[#000066] mb-2">
                            Tamaño
                        </label>

                        <div class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2
                                    text-xs sm:text-sm text-gray-700">
                            {{ $breed->size }}
                        </div>
                    </div>

                    <!-- Confirmación -->
                    <div class="mb-8 text-center">
                        <p class="text-sm sm:text-base text-gray-600">
                            ¿Está seguro de que desea eliminar esta Raza?
                        </p>
                    </div>

                    <!-- Botones -->
                    <div class="flex flex-col sm:flex-row sm:justify-end gap-3">

                        <!-- Eliminar -->
                        <button
                            type="submit"
                            class="w-full sm:w-auto px-5 py-2 rounded-xl border-2 border-[#000066]
                                   bg-[#000066] text-white
                                   text-xs sm:text-sm
                                   hover:bg-[#00004d]
                                   transition">
                            Eliminar Raza
                        </button>

                        <!-- Cancelar -->
                        <a
                            href="{{ route('admin.breeds.index') }}"
                            class="w-full sm:w-auto px-5 py-2 rounded-xl border-2 border-gray-400
                                   text-gray-600 text-center
                                   text-xs sm:text-sm
                                   hover:bg-gray-100 transition">
                            Cancelar
                        </a>

                    </div>

                </form>

            </section>

        </div>

    </div>

</x-app-layout>
