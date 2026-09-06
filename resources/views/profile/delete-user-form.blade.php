<div class="w-full">
    <div class="h-full bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8 shadow-sm">

        <div>
            <h3 class="text-xl font-bold text-[#000066]">
                Eliminar cuenta
            </h3>

            <p class="mt-2 text-gray-500 leading-relaxed">
                Elimina permanentemente tu cuenta.
            </p>
        </div>

        <div class="mt-6 bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl px-6 py-6">

            <div class="max-w-xl text-sm text-gray-600 leading-relaxed"> 
                Una vez que elimines tu cuenta, todos sus recursos y datos se eliminarán 
                permanentemente. Antes de eliminar tu cuenta, descarga cualquier dato o 
                información que quieras conservar. 
            </div>

            <div class="mt-5 flex justify-end"> 
                <button type="button" wire:click="confirmUserDeletion"
                wire:loading.attr="disabled" class="inline-flex items-center 
                justify-center rounded-xl border-2 border-red-500 bg-white px-5 py-2 
                text-sm font-semibold text-red-500 transition hover:bg-red-50
                hover:border-red-600 hover:text-red-600 focus:outline-none 
                focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50">
                 Eliminar cuenta 
                </button> 
            </div>

        </div>

        <!-- Modal de confirmación para eliminar usuario --> 
        <x-dialog-modal wire:model.live="confirmingUserDeletion"> 
            <x-slot name="title"> 
                Eliminar cuenta 
            </x-slot> 
            
            <x-slot name="content"> 
                <p class="text-gray-600 leading-relaxed"> 
                    ¿Estás seguro de que quieres eliminar tu cuenta? Una vez eliminada, 
                    todos sus recursos y datos se eliminarán permanentemente. 
                    Ingresa tu contraseña para confirmar que deseas eliminar tu cuenta. 
                </p> 
                <div class="mt-5" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)"> 
                    <x-input type="password" class="mt-1 block w-full" 
                    autocomplete="current-password" placeholder="Contraseña" 
                    x-ref="password" wire:model.live="password" wire:keydown.enter="deleteUser"/> 
                    <x-input-error for="password" class="mt-2" /> 
                </div> 
            </x-slot> 

            <x-slot name="footer"> 
                <button type="button" wire:click="$toggle('confirmingUserDeletion')" 
                wire:loading.attr="disabled" class="inline-flex items-center justify-center 
                rounded-xl border-2 border-[#000066] bg-white px-5 py-2 text-sm font-semibold 
                text-[#000066] transition hover:bg-[#F1F5F9] focus:outline-none focus:ring-2 
                focus:ring-[#000066] focus:ring-offset-2 disabled:opacity-50" > 
                Cancelar 
                </button> 

                <button type="button" wire:click="deleteUser" wire:loading.attr="disabled" 
                class="ms-3 inline-flex items-center justify-center rounded-xl border-2
                border-red-500 bg-white px-5 py-2 text-sm font-semibold text-red-500 
                transition hover:bg-red-50 hover:border-red-600 hover:text-red-600 
                focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 
                disabled:opacity-50" > 
                Eliminar cuenta 
                </button> 
            </x-slot> 
        </x-dialog-modal>

    </div>
</div>
