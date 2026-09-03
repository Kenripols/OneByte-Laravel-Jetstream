<x-app-layout>

<div class="min-h-screen bg-[#F5F8FF] pt-0 pb-12 lg:py-12 px-4">

    <div class="max-w-2xl mx-auto">

        {{-- ENCABEZADO --}}
        <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8 sm:p-10 text-center shadow-sm">

            <h1 class="text-3xl font-bold text-[#000066]">
                Asociar QR a una mascota
            </h1>

            <p class="mt-4 text-gray-500 text-base sm:text-lg leading-relaxed">
                Seleccioná una de tus mascotas para asociarla con el código QR.
            </p>

        </div>

        {{-- CONTENIDO --}}
        <div class="mt-8 bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-6 sm:p-8 shadow-sm">

            @if($pets->count())

                <form method="POST" action="{{ route('owner.qrplates.store') }}">
                    @csrf

                    {{-- MASCOTA --}}
                    <div>

                        <label
                            for="pet_id"
                            class="block text-gray-700 font-semibold mb-2"
                        >
                            Elegir mascota
                        </label>

                        <select
                            name="pet_id"
                            id="pet_id"
                            class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2 focus:ring-1 focus:ring-[#000066] focus:border-[#000066]"
                            required
                        >
                            @foreach($pets as $pet)
                                <option value="{{ $pet->id }}">
                                    {{ $pet->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    {{-- QR --}}
                    <input
                        type="hidden"
                        name="qr_id"
                        value="{{ session('claimed_qr_id') }}"
                    >

                    {{-- BOTÓN --}}
                    <div class="mt-8">

                        <button
                            type="submit"
                            class="w-full bg-white text-[#000066] border-2 border-[#000066] rounded-xl px-5 py-3 font-semibold shadow-sm transition hover:bg-[#F1F5F9]"
                        >
                            Asociar QR
                        </button>

                    </div>

                </form>

            @else

                <div class="bg-[#EEF5FF] border border-[#000066]/20 rounded-2xl px-5 py-5 text-center">

                    <p class="text-gray-600 leading-relaxed">
                        No tenés mascotas registradas.
                        Podés crear una luego de escanear un QR.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

</x-app-layout>