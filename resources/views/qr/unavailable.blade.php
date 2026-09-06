<!-- // Reemplazamos por el layout de guest porque sino queda inaccesible al no tener una sesión -->

<x-guest-layout>

    <div class="min-h-[70vh] flex items-center justify-center px-4 py-10">

        <div class="w-full max-w-xl">

            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8 sm:p-10 shadow-sm text-center">

                {{-- Título --}}
                <h1 class="text-3xl font-bold text-[#000066]">
                    QR no disponible
                </h1>

                {{-- Mensaje --}}
                <p class="mt-5 text-gray-600 text-base sm:text-lg leading-relaxed">
                    Este código QR ya fue usado, está vencido o no es válido.
                </p>

                {{-- Separador visual --}}
                <div class="mt-8 mx-auto w-16 h-1 rounded-full bg-[#000066]"></div>

                {{-- Información adicional --}}
                <p class="mt-6 text-sm text-gray-500 leading-relaxed">
                    Si creés que esto es un error, verificá que estés utilizando
                    un código QR válido de PetFinder.
                </p>

            </div>

        </div>

    </div>

</x-guest-layout>