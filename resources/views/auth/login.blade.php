<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Correo Electrónico') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Recuerdame') }}</span>
                </label>
            </div>

           

                <div class="flex justify-center gap-4 mt-6">

                    <a href="{{ url('/') }}"
                    class="w-40 inline-flex items-center justify-center
                            px-4 py-2
                            bg-white
                            border-2 border-[#000066]
                            rounded-md
                            font-semibold
                            text-sm
                            text-[#000066]
                            tracking-widest
                            hover:bg-[#F3F4F6]
                            hover:scale-105
                            transition-all duration-200">
                        Cancelar
                    </a>

                    <x-button class="w-40 justify-center">
                        {{ __('Iniciar sesión') }}
                    </x-button>

                </div>

                @if (Route::has('password.request'))
                    <div class="text-center mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                @endif

            
        </form>
    </x-authentication-card>
</x-guest-layout>
