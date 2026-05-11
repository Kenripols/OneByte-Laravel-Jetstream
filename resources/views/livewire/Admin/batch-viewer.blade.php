<div>

    <!-- selector -->
    <select wire:model.live="selectedBatch" class="border p-2 w-full mb-4">

    
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

    @if($selectedBatch)

        <div class="mt-4">

            <h3 class="text-lg font-semibold mb-4">
                {{ $selectedBatch === 'disponibles' 
                    ? 'QR disponibles' 
                    : 'QR del lote ' . $selectedBatch }}
            </h3>

            @if($qrs->isEmpty())
                <div class="text-gray-500">
                    No hay QR en este lote
                </div>
            @else

                <div class="overflow-x-auto">
                    <table class="min-w-full border bg-white text-sm">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 border text-left">ID</th>
                                <th class="p-2 border text-left">Código</th>
                                <th class="p-2 border text-left">Batch</th>
                                <th class="p-2 border text-left">Estado</th>
                                <th class="p-2 border text-center">Acciones</th>
                            </tr>
                        </thead>

                       <tbody>
                            @foreach($qrs as $qr)
                                <tr class="border-t hover:bg-gray-50">

                                    <td class="p-2 border">
                                        {{ $qr->id }}
                                    </td>

                                    <td class="p-2 border break-all">
                                        {{ $qr->code }}
                                    </td>

                                    <td class="p-2 border">
                                        {{ $qr->batch_id ?? 'Disponible' }}
                                    </td>

                                    <td class="p-2 border">
                                        {{ $qr->status_label }}
                                    </td>

                                    <td class="p-2 border text-center space-x-2">
                                        <button onclick="copyLink('{{ url('/qr/' . $qr->code) }}', this)"
                                            class="bg-blue-500 text-white px-2 py-1 rounded text-xs">
                                            Copiar
                                        </button>

                                        <!-- FUTURO: botón timeline -->
                                        <button wire:click="showTimeline({{ $qr->id }})"
                                            class="bg-gray-600 text-white px-2 py-1 rounded text-xs">
                                            Ver
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- paginación -->
                <div class="mt-4">
                    {{ $qrs->links() }}
                </div>

            @endif
        </div>

    @endif

</div>
<script>
function copyLink(link, btn) {
    // método fallback universal
    const input = document.createElement('input');
    input.value = link;
    document.body.appendChild(input);
    input.select();
    document.execCommand('copy');
    document.body.removeChild(input);

    // feedback visual
    const original = btn.innerText;
    btn.innerText = "Copiado";

    setTimeout(() => {
        btn.innerText = original;
    }, 100000);
}
</script>