<x-layouts.app>
    <!-- Breadcrumbs y título principal -->
    <div class="mb-8 flex justify-between items-center container mx-auto">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('home') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.usuarios.index') }}">Usuarios</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Detalle Usuario: {{ $usuario->nombre }} {{ $usuario->apellidos }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <!-- Contenedor principal -->
    <div class="container mx-auto px-4 max-w-4xl">
        {{-- <!-- Avatar -->
        <div class="w-full max-w-xs mx-auto mb-8">
            <img class="w-48 h-48 rounded-full object-cover object-center shadow-md mx-auto"
                src="{{ $usuario->avatar ? Storage::url($usuario->avatar) : 'https://ui-avatars.com/api/?name=' . '&size=256' }}"
                alt=""> --}}
        <!--Cogemos l url que nos genera el paquete-->
        <img id="imgPreview" class="w-48 h-48 rounded-full object-cover object-center shadow-md mx-auto"
            src=" {{ $usuario->avatar ? Storage::url($usuario->avatar) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg' }}"
            alt="img">
    </div>

    <!-- Nombre y apellidos destacados -->
    <h1 class="text-4xl font-extrabold text-gray-800 mb-6 text-center">
        {{ $usuario->nombre }} {{ $usuario->apellidos }}
    </h1>

    <!-- Información del usuario -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-base text-gray-700 mt-8 font-medium">
        <div class="bg-gray-100 dark:bg-zinc-700 p-5 rounded-lg shadow">
            <p class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Nick</p>
            <p>{{ $usuario->nick }}</p>
        </div>
        <div class="bg-gray-100 dark:bg-zinc-700 p-5 rounded-lg shadow">
            <p class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Email</p>
            <p>{{ $usuario->email }}</p>
        </div>
        <div class="bg-gray-100 dark:bg-zinc-700 p-5 rounded-lg shadow">
            <p class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Rol</p>
            <p>{{ $usuario->rol }}</p>
        </div>
        <!-- Total de Entradas -->
        <div class="bg-gray-100 dark:bg-zinc-700 p-5 rounded-lg shadow">
            <p class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Total de Entradas</p>
            <p>{{ $totalEntradas }}</p>
        </div>
    </div>
    </div>
</x-layouts.app>
