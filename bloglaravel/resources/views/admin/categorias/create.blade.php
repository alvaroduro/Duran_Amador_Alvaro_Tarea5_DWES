<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.categorias.index') }}">Categorías</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Nueva Categoría</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="card">
        <form action="{{ route('admin.categorias.store') }}" method="POST" class="space-y-4">
            @csrf
            <flux:input label="Nombre" name="nombre" value="{{old('nombre')}}" placeholder="Escribe el nombre de la Categoría">
            </flux:input>
            <div class="flex justify-end mt-3">
                <flux:button type="submit" variant="primary">Crear Categoría</flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>
