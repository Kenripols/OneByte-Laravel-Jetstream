<div>

    <!-- selector -->
    <select wire:model="selectedBatch" class="border p-2 w-full mb-4">

    
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
                                <th class="p-2 border text-left">Generado</th>
                                <th class="p-2 border text-left">Descargado</th>
                                <th class="p-2 border text-left">Asignado</th>
                                <th class="p-2 border text-center">QR</th>
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
                                        {{ $qr->generated_at 
                                            ? \Carbon\Carbon::parse($qr->generated_at)->format('d/m/Y H:i') 
                                            : '-' }}
                                    </td>

                                    <td class="p-2 border">
                                        {{ $qr->downloaded_at 
                                            ? \Carbon\Carbon::parse($qr->downloaded_at)->format('d/m/Y H:i') 
                                            : '-' }}
                                    </td>

                                    <td class="p-2 border text-center">
                                        {{ $qr->pet_id ? '🐶' : '—' }}
                                    </td>

                                   <td class="p-2 border text-center">
                                    <a href="{{ url('/p/' . $qr->code) }}" target="_blank" class="bg-blue-500 text-white px-2 py-1 rounded text-xs"> Abrir  </a>
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