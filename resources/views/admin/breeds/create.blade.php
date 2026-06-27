<x-app-layout>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-3xl mx-auto space-y-8">

            <!-- Encabezado -->
            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-8">

                <h1 class="text-3xl font-bold text-center text-[#000066]">
                    Crear Raza
                </h1>

                <p class="mt-3 text-gray-500 text-center text-lg leading-relaxed">
                    Completar los campos para registrar una Raza nueva
                </p>

            </section>

            <!-- Formulario -->
            <section class="bg-[#F8FAFC] rounded-3xl border-2 border-[#000066] p-8">

                <form action="{{ route('admin.breeds.store') }}" method="POST">
                    @csrf

                    <!-- Especie -->
                    <div class="mb-6">
                        <label for="animalType"
                               class="block text-sm font-semibold text-[#000066] mb-2">
                            Especie
                        </label>

                        <select
                            name="animalType"
                            id="animalType"
                            class="w-full rounded-xl border border-gray-300 px-4 py-2
                                   focus:ring-1 focus:ring-[#000066]
                                   focus:border-[#000066]"
                            required>

                            <option value="Perro" selected>Perro</option>
                            <option value="Gato">Gato</option>
                            <option value="Otro">Otro</option>

                        </select>
                    </div>

                    <!-- Nombre -->
                    <div class="mb-6">
                        <label for="breedName"
                               class="block text-sm font-semibold text-[#000066] mb-2">
                            Nombre de la raza
                        </label>

                        <input
                            type="text"
                            name="breedName"
                            id="breedName"
                            class="w-full rounded-xl border border-gray-300 px-4 py-2
                                   focus:ring-1 focus:ring-[#000066]
                                   focus:border-[#000066]"
                            required>
                    </div>

                    <!-- Tamaño -->
                    <div class="mb-8">
                        <label for="size"
                               class="block text-sm font-semibold text-[#000066] mb-2">
                            Tamaño
                        </label>

                        <select
                            name="size"
                            id="size"
                            class="w-full rounded-xl border border-gray-300 px-4 py-2
                                   focus:ring-1 focus:ring-[#000066]
                                   focus:border-[#000066]"
                            required>

                            <option value="Pequeño" selected>Pequeño</option>
                            <option value="Mediano">Mediano</option>
                            <option value="Grande">Grande</option>

                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end gap-3">

                        <button
                            type="submit"
                            class="px-5 py-2
                                border-2 border-[#000066]
                                text-[#000066]
                                rounded-xl
                                font-semibold
                                hover:bg-[#F1F5F9]
                                transition">
                            Guardar
                        </button>

                        <a href="{{ route('admin.breeds.index') }}"
                            class="px-5 py-2
                                    border-2 border-gray-400
                                    text-gray-600
                                    rounded-xl
                                    font-semibold
                                    hover:bg-gray-100
                                    transition">
                                Cancelar
                            </a>
                    </div>

                </form>

            </section>

        </div>

    </div>

</x-app-layout>