<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $nick = '';
    public string $nombre = '';
    public string $apellidos = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Campo rol con valor fijo (oculto en el formulario)
    public string $rol = 'user';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'nick' => 'required|string|min:3|max:50|unique:users,nick',
            'nombre' => 'required|string|min:2|max:255',
            'apellidos' => 'required|string|min:2|max:255',
            'email' => ['required', 'string', 'min:8', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'nick.required' => 'El nick es obligatorio.',
            'nick.unique' => 'Ya existe un usuario con ese nick.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debes proporcionar un email válido.',
            'email.unique' => 'Ya existe un usuario con ese email.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'rol.in' => 'El rol debe ser válido.',
        ]);

        // Añadir rol por defecto
        $validated['rol'] = 'user';

        // Encriptar la contraseña
        $validated['password'] = Hash::make($validated['password']);

        // Crear usuario y autenticar
        event(new Registered(($user = User::create($validated))));
        Auth::login($user);

        // Redirigir al dashboard
        $this->redirectIntended(route('home', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header 
        title="Crear una cuenta"
        description="Introduce tus datos para registrarte"
    />

    <!-- Mensaje de sesión -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Nombre -->
        <flux:input
            wire:model="nombre"
            label="Nombre"
            type="text"
            required
            autofocus
            autocomplete="nombre"
            placeholder="Introduce tu nombre"
        />

        <!-- Apellidos -->
        <flux:input
            wire:model="apellidos"
            label="Apellidos"
            type="text"
            required
            autocomplete="apellidos"
            placeholder="Introduce tus apellidos"
        />

        <!-- Nick -->
        <flux:input
            wire:model="nick"
            label="Usuario"
            type="text"
            required
            autocomplete="nickname"
            placeholder="Ej: alvaro22"
        />

        <!-- Email -->
        <flux:input
            wire:model="email"
            label="Email"
            type="email"
            required
            autocomplete="email"
            placeholder="correo@ejemplo.com"
        />

        <!-- Contraseña -->
        <flux:input
            wire:model="password"
            label="Contraseña"
            type="password"
            required
            autocomplete="new-password"
            placeholder="Introduce una contraseña"
            viewable
        />

        <!-- Confirmar contraseña -->
        <flux:input
            wire:model="password_confirmation"
            label="Confirmar contraseña"
            type="password"
            required
            autocomplete="new-password"
            placeholder="Repite la contraseña"
            viewable
        />

        <!-- Botón registrar -->
        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                Crear cuenta
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        ¿Ya tienes una cuenta?
        <flux:link :href="route('login')" wire:navigate>Inicia sesión</flux:link>
    </div>
</div>

