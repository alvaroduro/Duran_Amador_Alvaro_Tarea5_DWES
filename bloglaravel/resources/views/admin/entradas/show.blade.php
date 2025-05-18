<x-layouts.app>
    <!-- Breadcrumbs y título principal -->
    <div class="mb-8 flex justify-between items-center container mx-auto">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('home') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.entradas.index') }}">Entradas</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Detalle Entrada: {{ $entrada->titulo }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <!-- Contenedor principal -->
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Título -->
        <h1 class="text-4xl font-extrabold text-gray-800 mb-4 text-center">{{ $entrada->titulo }}</h1>

        <!-- Descripción -->
        <p class="text-lg text-gray-600 mb-6 text-center leading-relaxed">
            {{ $entrada->descripcion }}
        </p>

        <!--Cogemos l url que nos genera el paquete-->
        <img id="imgPreview" class="w-full h-auto aspect-video object-cover object-center rounded-md shadow-md"
            src=" {{ $entrada->imagen ? Storage::url($entrada->imagen) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg' }}"
            alt="img">

        <!-- Información adicional -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center text-base text-gray-700 mt-8 font-medium">
            <div class="bg-gray-100 dark:bg-zinc-700 p-5 rounded-lg shadow">
                <p class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Autor</p>
                <p>{{ $entrada->usuario->name }}</p>
            </div>
            <div class="bg-gray-100 dark:bg-zinc-700 p-5 rounded-lg shadow">
                <p class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Categoría</p>
                <p>{{ $entrada->categoria->nombre }}</p>
            </div>
            <div class="bg-gray-100 dark:bg-zinc-700 p-5 rounded-lg shadow">
                <p class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Publicado</p>
                <p>{{ $entrada->fecha_publicacion }}</p>
            </div>
        </div>
    </div>
</x-layouts.app>
