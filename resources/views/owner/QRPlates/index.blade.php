<x-app-layout>

    <div class="min-h-screen bg-[#F5F8FF] pt-0 pb-12 lg:py-12 px-4">

        <div class="max-w-7xl mx-auto">

            {{-- ENCABEZADO --}}
            <div class="text-center mb-8">

                <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8 sm:p-10 text-center shadow-sm mb-8">

                <h1 class="text-3xl font-bold text-[#000066]">
                    Placas QR asociadas
                </h1>

                <p class="mt-4 text-gray-500 text-base sm:text-lg leading-relaxed">
                    Consultá los códigos QR asociados a tus mascotas y revisá su información.
                </p>

            </div>

            {{-- MENSAJE DE ERROR --}}
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-2 border-red-200 rounded-3xl px-6 py-4">
                    <p class="text-red-600 text-sm">
                        {{ session('error') }}
                    </p>
                </div>
            @endif

            {{-- TABLA --}}
            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl shadow-sm overflow-hidden">

                <div class="w-full overflow-hidden">

                    <table class="w-full table-fixed divide-y divide-gray-200">

                        <thead>
                            <tr class="bg-[#EEF5FF]">

                                <th
                                    scope="col"
                                    class="w-[10%] px-3 sm:px-5 py-4 text-center text-xs font-semibold text-[#000066] uppercase tracking-wider leading-tight"
                                >
                                    ID QR
                                </th>

                                <th
                                    scope="col"
                                    class="w-[17%] px-3 sm:px-5 py-4 text-center text-xs font-semibold text-[#000066] uppercase tracking-wider leading-tight"
                                >
                                    Código QR
                                </th>

                                <th
                                    scope="col"
                                    class="w-[17%] px-3 sm:px-5 py-4 text-center text-xs font-semibold text-[#000066] uppercase tracking-wider leading-tight"
                                >
                                    Fecha de registro
                                </th>

                                <th
                                    scope="col"
                                    class="w-[18%] px-3 sm:px-5 py-4 text-center text-xs font-semibold text-[#000066] uppercase tracking-wider leading-tight"
                                >
                                    Fecha de vencimiento
                                </th>

                                <th
                                    scope="col"
                                    class="w-[18%] px-3 sm:px-5 py-4 text-center text-xs font-semibold text-[#000066] uppercase tracking-wider leading-tight"
                                >
                                    ID mascota asociada
                                </th>

                                <th
                                    scope="col"
                                    class="w-[20%] px-3 sm:px-5 py-4 text-center text-xs font-semibold text-[#000066] uppercase tracking-wider leading-tight"
                                >
                                    Acción
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @foreach ($QrPlates as $QrPlate)

                                <tr class="hover:bg-[#F1F5F9] transition">

                                    <td class="px-3 sm:px-5 py-4 text-center text-sm text-gray-700">
                                        {{ $QrPlate->id }}
                                    </td>

                                    <td class="px-3 sm:px-5 py-4 text-center text-sm font-semibold text-[#000066] break-words">
                                        {{ $QrPlate->code }}
                                    </td>

                                    <td class="px-3 sm:px-5 py-4 text-center text-sm text-gray-600 break-words">
                                        {{ $QrPlate->iDate }}
                                    </td>

                                    <td class="px-3 sm:px-5 py-4 text-center text-sm text-gray-600 break-words">
                                        {{ $QrPlate->eDate }}
                                    </td>

                                    <td class="px-3 sm:px-5 py-4 text-center text-sm text-gray-700">
                                        {{ $QrPlate->pet_id }}
                                    </td>

                                    <td class="px-3 sm:px-5 py-4 text-center">

                                        {{-- <a
                                            href="{{ route('owner.qrplates.show', $QrPlate) }}"
                                            class="inline-flex items-center justify-center bg-white text-[#000066] border-2 border-[#000066] rounded-xl px-3 sm:px-4 py-2 text-sm font-semibold transition hover:bg-[#F1F5F9]"
                                        >
                                            Ver detalles
                                        </a> --}}

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                {{-- PAGINACIÓN --}}
                <div class="px-4 sm:px-6 py-5 border-t border-gray-200">
                    {{ $QrPlates->links() }}
                </div>

            </div>

        </div>

    </div>

</x-app-layout>