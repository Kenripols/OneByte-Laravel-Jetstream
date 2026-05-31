<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mt-4">
                <x-label for="email" value="{{ __('Correo Electrónico') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

       <!-- Agrego campos a parte de los predeterminados en Jetstream -->
            <div class="mt-4">
                <x-label for="docType" value="{{ __('Tipo de Documento') }}" />
                <select id="docType" name="docType" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="2">{{ __('Pasaporte') }}</option>
                    <option value="1">{{ __('Cedula') }}</option>
                </select>
            </div>

            <div class="mt-4">
                <x-label for="docNum" value="{{ __('Numero de documento') }}" />
                <x-input id="docNum" class="block mt-1 w-full" type="text" name="docNum" :value="old('docNum')" required />
            </div>

            <div class="mt-4">
                <x-label for="fName1" value="{{ __('Primer Nombre') }}" />
                <x-input id="fName1" class="block mt-1 w-full" type="text" name="fName1" :value="old('fName1')" required autofocus />
            </div>
            <div class="mt-4">
                <x-label for="fName2" value="{{ __('Segundo Nombre') }}" />
                <x-input id="fName2" class="block mt-1 w-full" type="text" name="fName2" :value="old('fName2')" />
            </div>
            <div class="mt-4">
                <x-label for="sName1" value="{{ __('Primer Apellido') }}" />
                <x-input id="sName1" class="block mt-1 w-full" type="text" name="sName1" :value="old('sName1')" required />
            </div>

            <div class="mt-4">
                <x-label for="sName2" value="{{ __('Segundo Apellido') }}" />
                <x-input id="sName2" class="block mt-1 w-full" type="text" name="sName2" :value="old('sName2')" />
            </div>
         <!-- Terminan campos agregados de owner -->

            <div class="mt-4">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <!-- Botones Registrarse, Cancelar y ya estas registrado -->
            <div class="flex justify-center gap-4 mt-6">

                <a href="{{ url('/') }}"
                class="w-40 inline-flex items-center justify-center
                px-4 py-2
                bg-[#F8FAFC]
                border-2 border-[#000066]
                rounded-md
                font-semibold
                text-sm
                text-[#000066]
                tracking-widest
                hover:bg-[#F8FAFC]
                hover:text-white
                hover:scale-105
                transition-all duration-200">
                Cancelar
                </a>

                <x-button class="w-40 justify-center">
                    {{ __('Registrarse') }}
                </x-button>

            </div>

            <div class="text-center mt-4">

                <a href="{{ route('login') }}"
                class="underline text-sm text-gray-600 hover:text-gray-900">
                    ¿Ya estás registrado?
                </a>

            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
