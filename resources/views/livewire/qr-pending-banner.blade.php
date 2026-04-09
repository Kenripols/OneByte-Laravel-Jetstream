<div>
    @if($qr)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-4 flex justify-between items-center">

            <div>
                <strong>Tenés un QR pendiente</strong>
                <p class="text-sm">Completá la asignación</p>
            </div>

            <button wire:click="openModal"
                class="px-4 py-2 bg-yellow-500 text-white rounded shadow pulse-btn">
                Continuar
            </button>

        </div>
    @endif
</div>