<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ env('APP_URL') }}">
                <img src="{{ env('APP_URL') }}/img/logo-full.png" style="width: 300px;"/>
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Esta é uma área segura do aplicativo. Por favor, confirme sua senha antes de continuar.') }}
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <div class="flex justify-end mt-4">
                <x-button>
                    {{ __('Confirme') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
