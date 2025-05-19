<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login():void
    {
        // Validaciones
        $this->validate([
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string']
    ], [
        'email.required' => 'El email es obligatorio.',
        'email.string' => 'El email debe ser una cadena de texto.',
        'email.email' => 'Debe ingresar un correo electrónico válido.',
        'password.required' => 'La contraseña es obligatoria.',
        'password.string' => 'La contraseña debe ser una cadena de texto.',
    ]);

        // Intentos fallidos
        $this->ensureIsNotRateLimited();
        
        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('Creedenciales Inválidas'),
            ]);
        }
        
        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);

    }
 

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<!--Form Login-->
<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Ingrese en su cuenta')" :description="__('Introduzca su email y su contraseña para iniciar sesión')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />
    <!--Formulario de inicio sesion-->
    <form wire:submit="login"  class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Contraseña')"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('olvidaste tu contraseña?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Recuérdame')" />


        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit"
            class="w-full" >{{ __('Iniciar Sesión') }}</flux:button>
        </div>

    </form>

    <div class="text-center">
        <a href="{{ route('google.redirect') }}" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <!-- SVG del logo de Google -->
                <path d="M21.805 10.023H12v3.994h5.629c-.244 1.29-.975 2.382-2.063 3.097v2.572h3.343c1.957-1.804 3.096-4.46 3.096-7.663 0-.65-.058-1.282-.167-1.9z"/>
                <path d="M12 22c2.7 0 4.961-.891 6.613-2.406l-3.343-2.572c-.926.62-2.117.99-3.27.99-2.512 0-4.637-1.693-5.396-3.97H3.148v2.49A9.996 9.996 0 0012 22z"/>
                <path d="M6.604 13.042a5.99 5.99 0 010-3.083v-2.49H3.148a9.998 9.998 0 000 8.063l3.456-2.49z"/>
                <path d="M12 6.084c1.47 0 2.788.506 3.825 1.496l2.862-2.863C16.958 2.89 14.7 2 12 2a9.996 9.996 0 00-8.852 5.469l3.456 2.49C7.363 7.778 9.488 6.084 12 6.084z"/>
            </svg>
            Iniciar sesión con Google
        </a>
    </div>
    

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('No tienes cuenta?') }}
            <flux:link :href="route('register')" wire:navigate>{{ __('Registrate') }}</flux:link>
        </div>
    @endif
</div>





