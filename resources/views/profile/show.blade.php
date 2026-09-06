<x-app-layout>

    <x-slot name="header">
        <div class="max-w-7xl mx-auto">
            <div class="bg-[#F8FAFC] border-2 border-[#000066] rounded-3xl px-6 py-6">
                <h2 class="text-3xl font-bold text-[#000066] text-center">
                    Mi perfil
                </h2>

                <p class="mt-3 text-gray-500 text-center text-lg leading-relaxed">
                    Administra la información y seguridad de tu cuenta.
                </p>
            </div>
        </div>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

            {{-- INFORMACIÓN DE PERFIL Y ACTUALIZAR CONTRASEÑA --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">

                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    @livewire('profile.update-profile-information-form')
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    @livewire('profile.update-password-form')
                @endif

            </div>

            {{-- AUTENTICACIÓN DE DOBLE FACTOR --}}
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-6">
                    @livewire('profile.two-factor-authentication-form')
                </div>
            @endif

            <x-section-border />

            {{-- CERRAR SESIONES EN OTROS NAVEGADORES --}}
            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            {{-- ELIMINAR CUENTA --}}
            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif

        </div>
    </div>

</x-app-layout>