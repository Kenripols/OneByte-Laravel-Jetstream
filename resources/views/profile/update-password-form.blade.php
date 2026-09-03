<div class="w-full lg:w-1/2">
    <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8 shadow-sm">
        <form wire:submit="updatePassword">

            <div>
                <h3 class="text-xl font-bold text-[#000066]">
                    Actualizar contraseña
                </h3>

                <p class="mt-2 text-gray-500 leading-relaxed">
                    Recuerda utilizar Mayúsculas, Números y Simbolos para mayor Seguridad.
                </p>
            </div>

            <div class="mt-4 space-y-4">

                <div>
                
                    <x-input
                        id="current_password"
                        type="password"
                        class="mt-2 block w-full"
                        wire:model.live="state.current_password"
                        placeholder="Contraseña actual"
                        required
                        autocomplete="current-password"
                    />

                    <x-input-error
                        for="current_password"
                        class="mt-2"
                    />
                </div>

                <div>
                    
                    <x-input
                        id="password"
                        type="password"
                        class="mt-2 block w-full"
                        wire:model.live="state.password"
                        placeholder="Nueva contraseña"
                        autocomplete="new-password"
                    />

                    <x-input-error
                        for="password"
                        class="mt-2"
                    />
                </div>

                <div>
                    
                    <x-input
                        id="password_confirmation"
                        type="password"
                        class="mt-2 block w-full"
                        wire:model.live="state.password_confirmation"
                        placeholder="Confirmar contraseña"
                        autocomplete="new-password"
                    />

                    <x-input-error
                        for="password_confirmation"
                        class="mt-2"
                    />
                </div>

            </div>

            <div class="mt-6 flex justify-end items-center">
                <x-action-message
                    class="me-3"
                    on="saved"
                >
                    Guardado.
                </x-action-message>

                <x-button wire:loading.attr="disabled">
                    Guardar
                </x-button>
            </div>

        </form>
    </div>
</div>