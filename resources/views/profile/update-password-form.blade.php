<div class="w-full">
    <div class="h-full bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8 shadow-sm">
        <form wire:submit="updatePassword">

            <div>
                <h3 class="text-xl font-bold text-[#000066]">
                    Actualizar contraseña
                </h3>

                <p class="mt-2 min-h-[3.5rem] text-gray-500 leading-relaxed">
                    Recuerda utilizar Mayúsculas, Números y Simbolos para mayor Seguridad.
                </p>
            </div>

            <div class="mt-4 space-y-4">

                {{-- Contraseña actual --}}
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
                    <x-input-error for="current_password" class="mt-2" />
                </div>

                {{-- Nueva Contraseña y confirmar Contraseña --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                    <div>
                        <x-input
                            id="password"
                            type="password"
                            class="mt-2 block w-full"
                            wire:model.live="state.password"
                            placeholder="Nueva contraseña"
                            autocomplete="new-password"
                        />
                        <x-input-error for="password" class="mt-2" />
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
                        <x-input-error for="password_confirmation" class="mt-2" />
                    </div>

                </div>

            </div>

            <div class="mt-6 flex justify-end items-center">
                <x-action-message
                    class="me-3"
                    on="saved">
                    Guardado.
                </x-action-message>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center rounded-xl border-2 
                    border-[#000066] bg-white px-5 py-2 text-sm font-semibold 
                    text-[#000066] transition hover:bg-[#F1F5F9] focus:outline-none 
                    focus:ring-2 focus:ring-[#000066] focus:ring-offset-2 disabled:opacity-50">
                    Guardar
                </button>
            </div>

        </form>
    </div>
</div>