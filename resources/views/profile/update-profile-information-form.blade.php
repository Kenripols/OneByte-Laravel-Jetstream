<div class="w-full">
    <div class="h-full bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8 shadow-sm">
        <form wire:submit="updateProfileInformation">

            <div>
                <h3 class="text-xl font-bold text-[#000066]">
                    Información de perfil
                </h3>

                <p class="mt-2 min-h-[3.5rem] text-gray-500 leading-relaxed">
                    Actualiza tu dirección de correo electrónico.
                </p>
            </div>

            <div class="mt-4">

                <x-input
                    id="email"
                    type="email"
                    class="mt-2 block w-full"
                    wire:model.live="state.email"
                    placeholder="Correo electrónico"
                    required
                    autocomplete="username"
                />

                <x-input-error for="email" class="mt-2" />

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                    <p class="text-sm mt-2 text-gray-600">
                        {{ __('Tu dirección de correo electrónico no está verificada.') }}

                        <button
                            type="button"
                            class="underline text-sm text-gray-600 hover:text-[#000066]"
                            wire:click.prevent="sendEmailVerification">
                            {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                        </button>
                    </p>

                    @if ($this->verificationLinkSent)
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu correo electrónico.') }}
                        </p>
                    @endif
                @endif
            </div>

            <div class="mt-6 flex justify-end items-center">
                <x-action-message class="me-3" on="saved">
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