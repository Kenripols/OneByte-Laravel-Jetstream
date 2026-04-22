<div>
@if($qr)
    <div 
        wire:click="openModal"
        class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-4 flex justify-between items-center cursor-pointer hover:bg-yellow-200 transition"
    >
        <div class="flex items-center gap-3">            
            <div>
                <strong>Tenés un QR sin asociar</strong>
                <p class="text-sm">Asignalo a una mascota para activarlo</p>
            </div>
        </div>

        <div class="flex gap-2">
            <button wire:click.stop="openModal"
                class="px-4 py-2 bg-yellow-500 text-white rounded shadow">
                Continuar
            </button>

            <button wire:click.stop="forgetQr"
                class="px-3 py-2 bg-gray-200 rounded">
                Olvidar
            </button>
        </div>
    </div>
@endif
</div>