<div>

    <!-- Selector -->
    <div class="mb-6">
        <select
            wire:model.live="selectedBatch"
            class="w-full rounded-xl border border-gray-300 px-4 py-2
                   focus:ring-1 focus:ring-[#000066]
                   focus:border-[#000066]">

            @foreach($batches as $batch)
                <option value="{{ $batch }}">
                    @if($batch === 'disponibles')
                        Disponibles ({{ $this->disponiblesCount }})
                    @else
                        Lote {{ $batch }}
                    @endif
                </option>
            @endforeach

        </select>
    </div>

@if($selectedBatch)

    <div>

        <h3 class="text-2xl sm:text-3xl font-bold text-[#000066] text-center mb-6">
                {{ $selectedBatch === 'disponibles'
                    ? 'QR disponibles'
                    : 'QR del lote ' . $selectedBatch }}
        </h3>

@if($qrs->isEmpty())

    <div class="text-center text-gray-500 py-8">
        No hay QR en este lote.
    </div>

@else

    <div class="border-2 border-[#000066] rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-[900px] w-full divide-y divide-gray-200">

                <thead class="bg-[#F1F5F9] border-b-2 border-[#000066]">
                    <tr>

                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase text-[#000066]">
                            ID
                        </th>

                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase text-[#000066]">
                            Código
                        </th>

                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase text-[#000066]">
                            Lote
                        </th>

                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase text-[#000066]">
                            Estado
                        </th>

                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase text-[#000066] w-64">
                            Acciones
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">

                @foreach($qrs as $qr)

                    <tr class="hover:bg-[#F8FAFC] transition">

                        <td class="px-4 py-2 text-sm whitespace-nowrap">
                            {{ $qr->id }}
                        </td>

                        <td class="px-4 py-2 text-sm break-all">
                            {{ $qr->code }}
                        </td>

                        <td class="px-4 py-2 text-sm whitespace-nowrap">
                            {{ $qr->batch_id ?? 'Disponible' }}
                        </td>

                        <td class="px-4 py-2 text-sm whitespace-nowrap">
                            {{ $qr->status_label }}
                        </td>

                        <td class="px-4 py-2">

                        <div class="flex items-center justify-center gap-2">

                            <button onclick="copyLink('{{ url('/qr/' . $qr->code) }}', this)"
                                class="w-24 px-3 py-1 text-xs sm:text-sm border-2
                                border-[#000066] text-[#000066] rounded-lg hover:bg-[#F1F5F9] 
                                transition">
                                Copiar
                            </button>

                            <button disabled class="w-24 px-3 py-1 text-xs sm:text-sm
                                border-2 border-gray-400 text-gray-400 rounded-lg
                                cursor-not-allowed">
                                Ver
                            </button>

                        </div>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-6 border-2 border-[#000066] rounded-2xl p-4 bg-[#F8FAFC]">
        {{ $qrs->links() }}
    </div>

    @endif

    </div>

    @endif

</div>

<script>
function copyLink(link, btn) {

    const input = document.createElement('input');
    input.value = link;
    document.body.appendChild(input);
    input.select();
    document.execCommand('copy');
    document.body.removeChild(input);

    const original = btn.innerText;
    btn.innerText = 'Copiado';

    setTimeout(() => {
        btn.innerText = original;
    }, 1500);

}
</script>