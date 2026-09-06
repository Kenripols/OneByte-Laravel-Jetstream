<div class="w-full">
    <div class="h-full bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl p-8 shadow-sm">

        <div>
            <h3 class="text-xl font-bold text-[#000066]">
                Sesiones del navegador
            </h3>

            <p class="mt-2 text-gray-500 leading-relaxed">
                Administra y cierra las sesiones activas de tu cuenta en otros navegadores y dispositivos.
            </p>
        </div>

        <div class="mt-6 bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl px-6 py-6">

            <div class="mt-3 max-w-xl text-sm text-gray-600 leading-relaxed">
                <p>
                    Si es necesario, puedes cerrar la sesión de todos los demás navegadores y
                    dispositivos en los que tengas tu cuenta activa. A continuación se
                    muestran algunas de tus sesiones recientes; sin embargo, esta lista puede
                    no incluir todas las sesiones. Si crees que tu cuenta ha sido comprometida,
                    también deberías actualizar tu contraseña.
                </p>
            </div>

            @if (count($this->sessions) > 0)
                <div class="mt-5 space-y-6">

                    @foreach ($this->sessions as $session)
                        <div class="flex items-center">
                            <div>
                                @if ($session->agent->isDesktop())
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                    </svg>
                                @endif
                            </div>

                            <div class="ms-3">
                                <div class="text-sm text-gray-600">
                                    {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }} - {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                                </div>

                                <div>
                                    <div class="text-xs text-gray-500">
                                        {{ $session->ip_address }},

                                        @if ($session->is_current_device)
                                            <span class="text-green-500 font-semibold">{{ __('Este dispositivo') }}</span>
                                        @else
                                            {{ __('Last active') }} {{ $session->last_active }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            @endif

            <div class="mt-6 flex justify-end items-center">
                <x-action-message class="me-3" on="loggedOut">
                    Listo.
                </x-action-message>

                <button
                    type="button"
                    wire:click="confirmLogout"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center rounded-xl border-2 
                    border-[#000066] bg-white px-5 py-2 text-sm font-semibold 
                    text-[#000066] transition hover:bg-[#F1F5F9] focus:outline-none 
                    focus:ring-2 focus:ring-[#000066] focus:ring-offset-2 
                    disabled:opacity-50">
                    Cerrar otras sesiones
                </button>
            </div>

        </div>

        <x-dialog-modal wire:model.live="confirmingLogout">

            <x-slot name="title">
                Cerrar otras sesiones
            </x-slot>

            <x-slot name="content">
                <p class="text-gray-600 leading-relaxed">
                    Ingresa tu contraseña para confirmar que deseas cerrar las sesiones
                    activas de tu cuenta en los demás navegadores y dispositivos.
                </p>

                <div
                    class="mt-4"
                    x-data="{}"
                    x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input
                        type="password"
                        class="mt-1 block w-3/4"
                        autocomplete="current-password"
                        placeholder="Contraseña"
                        x-ref="password"
                        wire:model.live="password"
                        wire:keydown.enter="logoutOtherBrowserSessions"/>
                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">

                <button
                    type="button"
                    wire:click="$toggle('confirmingLogout')"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center rounded-xl border-2 
                    border-[#000066] bg-white px-5 py-2 text-sm font-semibold 
                    text-[#000066] transition hover:bg-[#F1F5F9] focus:outline-none 
                    focus:ring-2 focus:ring-[#000066] focus:ring-offset-2 
                    disabled:opacity-50">
                    Cancelar
                </button>

                <button
                    type="button"
                    wire:click="logoutOtherBrowserSessions"
                    wire:loading.attr="disabled"
                    class="ms-3 inline-flex items-center justify-center rounded-xl 
                    border-2 border-[#000066] bg-white px-5 py-2 text-sm 
                    font-semibold text-[#000066] transition hover:bg-[#F1F5F9] 
                    focus:outline-none focus:ring-2 focus:ring-[#000066] 
                    focus:ring-offset-2 disabled:opacity-50">
                    Cerrar otras sesiones
                </button>

            </x-slot>

        </x-dialog-modal>

    </div>
</div>

