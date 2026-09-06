<x-app-layout>

    <div class="min-h-screen bg-[#F5F8FF] pt-0 pb-12 lg:py-12 px-4">

        <div class="max-w-xl mx-auto">

            {{-- Error --}}
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-2 border-red-200 rounded-3xl px-6 py-4 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Tarjeta principal --}}
            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8 sm:p-10 shadow-sm text-center">

                <h1 class="text-3xl font-bold text-[#000066]">
                    ¿Qué querés hacer con el QR?
                </h1>

                <p class="mt-4 text-gray-500 text-base leading-relaxed">
                    Este código QR está disponible. Podés utilizarlo para comenzar
                    a asociarlo con una mascota.
                </p>

                <div class="mt-8">

                    <form method="POST" action="{{ route('owner.qr.claim', $qr->code) }}">
                        @csrf

                        <button
                            type="submit"
                            class="w-full bg-white text-[#000066] border-2 border-[#000066] rounded-xl px-5 py-3 font-semibold shadow-sm transition hover:bg-[#F1F5F9]"
                        >
                            Sí, usar QR
                        </button>
                    </form>

                    <a
                        href="{{ route('owner.dashboard') }}"
                        class="mt-4 flex w-full items-center justify-center bg-white text-gray-600 border-2 border-gray-300 rounded-xl px-5 py-3 font-semibold shadow-sm transition hover:bg-gray-50"
                    >
                        No, cancelar
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>