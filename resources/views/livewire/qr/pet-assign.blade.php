<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-6 sm:p-8 shadow-sm">

        <!-- Encabezado -->
        <div class="text-center">

            <h1 class="text-3xl font-bold text-[#000066]">
                Asociar QR a mascota
            </h1>

            <p class="mt-3 text-gray-500 text-base sm:text-lg leading-relaxed">
                Selecciona una mascota existente o crea una nueva para asociar el código QR.
            </p>

        </div>

        <!-- Contexto QR -->
        @if($qr)
            <div class="mt-6 bg-white border border-gray-200 rounded-2xl px-5 py-4">
                <p class="text-xs font-semibold text-[#000066] uppercase tracking-wider">
                    Código QR
                </p>

                <p class="mt-2 text-sm text-gray-700 break-all">
                    <strong>{{ $qr->uuid }}</strong>
                </p>
            </div>
        @endif

        <!-- Seleccionar Mascota -->
        <div class="mt-6">

            <label class="block text-sm font-semibold text-[#000066] mb-2">
                Mascota
            </label>

            <select
                wire:model.live="selectedPetId"
                class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2.5 focus:ring-1 focus:ring-[#000066] focus:border-[#000066]"
            >
                <option value="">
                    Nueva mascota
                </option>

                @foreach($pets as $pet)
                    <option value="{{ $pet->id }}">
                        {{ $pet->name }}
                    </option>
                @endforeach
            </select>

        </div>

        <!-- Mascota seleccionada -->
        @if($selectedPetId)

            <div class="mt-5 bg-white border border-gray-200 rounded-2xl px-5 py-4">

                <p class="text-xs font-semibold text-[#000066] uppercase tracking-wider">
                    Mascota seleccionada
                </p>

                <p class="mt-2 text-sm font-semibold text-gray-800">
                    {{ $pets->firstWhere('id', $selectedPetId)?->name }}
                </p>

            </div>

        @endif

        <!-- Formulario nueva mascota -->
        @if(!$selectedPetId)

            <div class="mt-6 pt-6 border-t border-gray-200">

                <!-- Nombre -->
                <div class="mb-5">

                    <label class="block text-sm font-semibold text-[#000066] mb-2">
                        Nombre
                    </label>

                    <input
                        type="text"
                        wire:model.live="name"
                        class="w-full rounded-xl border border-gray-300 px-3 py-2.5 focus:ring-1 focus:ring-[#000066] focus:border-[#000066]"
                        placeholder="Nombre de la mascota"
                    >

                    @error('name')
                        <p class="text-xs text-red-500 mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- Fecha de nacimiento -->
                <div class="mb-5">

                    <label class="block text-sm font-semibold text-[#000066] mb-2">
                        Fecha de nacimiento
                    </label>

                    <input
                        type="date"
                        wire:model.live="bDate"
                        class="w-full rounded-xl border border-gray-300 px-3 py-2.5 focus:ring-1 focus:ring-[#000066] focus:border-[#000066]"
                    >

                    @error('bDate')
                        <p class="text-xs text-red-500 mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- Raza -->
                <div class="mb-5">

                    <label class="block text-sm font-semibold text-[#000066] mb-2">
                        Raza
                    </label>

                    <select
                        wire:model.live="breed_id"
                        class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2.5 focus:ring-1 focus:ring-[#000066] focus:border-[#000066]"
                    >
                        <option value="">
                            Seleccione una raza
                        </option>

                        @foreach($breeds as $breed)
                            <option value="{{ $breed->id }}">
                                {{ $breed->breedName }}
                            </option>
                        @endforeach
                    </select>

                    @error('breed_id')
                        <p class="text-xs text-red-500 mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- Foto -->
                <div>

                    <label class="block text-sm font-semibold text-[#000066] mb-2">
                        Foto
                        <span class="font-normal text-gray-400">
                            (opcional)
                        </span>
                    </label>

                    <div class="bg-white border border-gray-200 rounded-xl p-4">

                        <label
                            for="pet-photo"
                            class="flex items-center justify-center w-full rounded-xl border-2 border-[#000066] bg-white px-4 py-3 text-sm font-semibold text-[#000066] cursor-pointer transition hover:bg-[#F1F5F9]"
                        >
                            Seleccionar foto
                        </label>

                        <input
                            id="pet-photo"
                            type="file"
                            wire:model="photo"
                            accept="image/*"
                            class="hidden"
                        >

                        @error('photo')
                            <p class="text-xs text-red-500 mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                        @if($photo)

                            <div class="mt-4 flex justify-center">

                                <img
                                    src="{{ $photo->temporaryUrl() }}"
                                    class="w-32 h-32 rounded-2xl object-cover border-2 border-[#000066]"
                                >

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        @endif

        <!-- Botón -->
        <div class="mt-8 flex justify-end">

            <button
                wire:click="save"
                type="button"
                class="inline-flex items-center justify-center rounded-xl border-2 border-[#000066] bg-white px-5 py-2.5 text-sm font-semibold text-[#000066] transition hover:bg-[#F1F5F9] focus:outline-none focus:ring-2 focus:ring-[#000066] focus:ring-offset-2"
            >
                {{ $selectedPetId ? 'Asociar a mascota' : 'Crear y asociar' }}
            </button>

        </div>

    </div>

</div>

