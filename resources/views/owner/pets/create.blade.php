<x-app-layout>

<div class="min-h-screen bg-[#F5F8FF] pt-0 pb-12 lg:py-12 px-4">

    <div class="max-w-2xl mx-auto">

        <div class="text-center mb-8">

            <h1 class="mt-4 text-3xl font-bold text-[#000066]">
                Ingresar Mascota
            </h1>

            <p class="mt-3 text-gray-500 text-lg leading-relaxed">
                Registrá una nueva mascota y comenzá a gestionar su información en PetFinder.
            </p>

        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-2 border-red-200 rounded-3xl px-6 py-4">
                <ul class="text-red-600 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-6 sm:p-8 shadow-sm">

            <form
                action="{{ route('owner.pets.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                <div class="mb-6">

                    <label
                        for="name"
                        class="block text-gray-700 font-semibold mb-2"
                    >
                        Nombre
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:ring-1 focus:ring-[#000066] focus:border-[#000066]"
                        required
                    >

                </div>

                <div class="mb-6">

                    <label
                        for="bDate"
                        class="block text-gray-700 font-semibold mb-2"
                    >
                        Fecha de nacimiento
                    </label>

                    <input
                        type="date"
                        name="bDate"
                        id="bDate"
                        value="{{ old('bDate') }}"
                        class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:ring-1 focus:ring-[#000066] focus:border-[#000066]"
                    >

                </div>

                <div class="mb-6">

                    <label
                        for="breed_id"
                        class="block text-gray-700 font-semibold mb-2"
                    >
                        Raza
                    </label>

                    <select
                        name="breed_id"
                        id="breed_id"
                        class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-white focus:ring-1 focus:ring-[#000066] focus:border-[#000066]"
                        required
                    >
                        <option value="">Seleccione una raza</option>

                        @foreach($breeds as $breed)
                            <option
                                value="{{ $breed->id }}"
                                {{ old('breed_id') == $breed->id ? 'selected' : '' }}
                            >
                                {{ $breed->breedName }} ({{ $breed->animalType }})
                            </option>
                        @endforeach

                    </select>

                </div>

                <div class="mb-8">

                    <label
                        for="photo"
                        class="block text-gray-700 font-semibold mb-2"
                    >
                        Foto de la mascota
                        <span class="font-normal text-gray-500">
                            (opcional)
                        </span>
                    </label>

                    <label
                        for="photo"
                        class="flex w-full items-center justify-center bg-white text-[#000066] border-2 border-[#000066] rounded-xl px-4 py-3 font-semibold cursor-pointer transition hover:bg-[#F1F5F9]"
                    >
                        Seleccionar archivo
                    </label>

                    <input
                        type="file"
                        name="photo"
                        id="photo"
                        accept="image/*"
                        class="hidden"
                    >

                    @error('photo')
                        <span class="block mt-2 text-red-500 text-sm">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <button
                    type="submit"
                    class="w-full bg-white text-[#000066] border-2 border-[#000066] rounded-xl px-5 py-3 font-semibold shadow-sm transition hover:bg-[#F1F5F9]"
                >
                    Guardar mascota
                </button>

            </form>

        </div>

    </div>

</div>

</x-app-layout>