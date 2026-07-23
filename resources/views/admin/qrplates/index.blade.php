<x-app-layout>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Título -->
            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8">

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-center text-[#000066]">
                    Generar QR
                </h1>

                <p class="mt-3 text-base sm:text-lg lg:text-xl text-center text-gray-500 leading-relaxed">
                    Genera nuevos lotes de placas QR y descargarlos para su impresión.
                </p>

            </div>

            <!-- Generación -->
            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-6 space-y-5">

                @if(session('success'))
                    <div class="rounded-xl border border-green-300 bg-green-50 px-4 py-3 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="rounded-xl border border-red-300 bg-red-50 px-4 py-3 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('admin.qrplates.generate') }}"
                    class="flex flex-col sm:flex-row items-center gap-4">

                    @csrf

                    <div class="flex flex-wrap items-center gap-3">
                        <input type="number" name="amount" min="1" required placeholder="Cantidad"
                        class="w-20 rounded-xl border border-gray-300 px-3 py-2 focus:ring-1 focus:ring-[#000066] focus:border-[#000066]">

                        <button type="submit" class="px-5 py-2 rounded-xl border-2 border-[#000066] bg-white text-[#000066] font-semibold hover:bg-[#F1F5F9] transition">
                        Generar QR
                        </button>

                        <button type="submit" formaction="{{ route('admin.qrplates.download') }}"
                        class="px-5 py-2 rounded-xl border-2 border-[#000066] bg-white text-[#000066] font-semibold hover:bg-[#F1F5F9] transition">
                        Descargar lote
                        </button>

                    </div>
                </form>

            </div>

            <!-- Tabla Livewire -->
            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-6">

                @livewire('admin.batch-viewer')

            </div>

        </div>

    </div>

</x-app-layout>