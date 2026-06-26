<x-app-layout>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-3xl mx-auto space-y-8">

            <!-- Encabezado -->
            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-8">

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-center text-[#000066]">
                    Editar Raza
                </h1>

                <p class="mt-3 text-gray-500 text-center text-base sm:text-lg lg:text-xl leading-relaxed">
                    Modificar datos de la raza seleccionada.
                </p>

            </section>

            <!-- Formulario -->
            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-8 shadow-sm">

                <form action="{{ route('admin.breeds.update', $breed) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Animal -->
                    <div class="mb-6">
                        <label for="animalType"
                               class="block text-[11px] sm:text-xs font-semibold text-[#000066] mb-2">
                            Tipo de Animal
                        </label>

                        <select
                            name="animalType"
                            id="animalType"
                            class="w-full rounded-xl border border-gray-300 px-4 py-2
                                text-xs sm:text-sm appearance-none
                                focus:ring-1 focus:ring-[#000066]
                                focus:border-[#000066]
                                transition"
                            required>

                            <option value="Perro" {{ $breed->animalType == "Perro" ? 'selected' : '' }}>
                                Perro
                            </option>

                            <option value="Gato" {{ $breed->animalType == "Gato" ? 'selected' : '' }}>
                                Gato
                            </option>

                            <option value="Otro" {{ $breed->animalType == "Otro" ? 'selected' : '' }}>
                                Otro
                            </option>

                        </select>
                    </div>

                    <!-- Nombre -->
                    <div class="mb-6">
                        <label for="breedName"
                               class="block text-[11px] sm:text-xs font-semibold text-[#000066] mb-2">
                            Nombre de la Raza
                        </label>

                        <input
                            type="text"
                            name="breedName"
                            id="breedName"
                            value="{{ $breed->breedName }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-2
                                   text-xs sm:text-sm appearance-none
                                focus:ring-1 focus:ring-[#000066]
                                focus:border-[#000066]
                                   transition"
                            required>
                    </div>

                    <!-- Tamaño -->
                    <div class="mb-8">
                        <label for="size"
                               class="block text-[11px] sm:text-xs font-semibold text-[#000066] mb-2">
                            Tamaño
                        </label>

                        <select
                            name="size"
                            id="size"
                            class="w-full rounded-xl border border-gray-300 px-4 py-2
                                   text-xs sm:text-sm appearance-none
                                   focus:ring-1 focus:ring-[#000066] focus:border-[#000066]
                                   transition"
                            required>

                            <option value="Pequeño" {{ $breed->size == "Pequeño" ? 'selected' : '' }}>
                                Pequeño
                            </option>

                            <option value="Mediano" {{ $breed->size == "Mediano" ? 'selected' : '' }}>
                                Mediano
                            </option>

                            <option value="Grande" {{ $breed->size == "Grande" ? 'selected' : '' }}>
                                Grande
                            </option>

                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="flex flex-col sm:flex-row sm:justify-end gap-3">

                        <!-- Actualizar -->
                        <button
                            type="submit"
                            class="w-full sm:w-auto px-5 py-2 rounded-xl border-2 border-[#000066]
                                   text-[#000066]
                                   text-xs sm:text-sm
                                   hover:bg-[#000066] hover:text-white
                                   transition">
                            Actualizar Raza
                        </button>

                        <!-- Cancelar -->
                        <a href="{{ route('admin.breeds.index') }}"
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