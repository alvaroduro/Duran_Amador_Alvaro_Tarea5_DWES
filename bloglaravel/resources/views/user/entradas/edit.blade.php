<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('user.entradas.index') }}">Entradas</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Editar Entrada</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <!--FORMULARIO ACTUALIZAR POST-->
    <form action="{{ route('user.entradas.update', $entrada) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!--Imagen-->
        <div class="relative mb-2 w-full max-w-4xl mx-auto">

           <!--Cogemos l url que nos genera el paquete-->
            <img id="imgPreview" 
                class="w-full h-auto aspect-video object-cover object-center rounded-md shadow-md" 
                src=" {{ $entrada->imagen ? Storage::url($entrada->imagen) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg'}}" 
                alt="img">

                <!--Imagen por defecto-->
            {{-- <img 
                class="w-full h-auto aspect-video object-cover object-center rounded-md shadow-md" 
                src="https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg" 
                alt="noimagen"> --}}

            <!-- Cambiar Imagen -->
            <div class="absolute top-4 right-4">
                <label class="bg-white px-4 py-2 rounded-lg shadow cursor-pointer text-sm hover:bg-gray-100">
                    Cambiar Imagen
                    <input class="hidden" type="file" name="imagen" accept="image/*" onchange="previewImage(event, '#imgPreview')">
                </label>
            </div>
        </div>

        <div class="card space-y-4">

            <!--FORMULARIO TITULO-->
            <flux:input label="Titulo" name="titulo" oninput="string_to_slug(this.value, '#slug')"
                value="{{ old('titulo', $entrada->titulo) }}" placeholder="Escribe el título de la entrada">
            </flux:input>

            <!--FORMULARIO SLUG-->
            <flux:input label="Slug" name="slug" id="slug" value="{{ old('slug', $entrada->slug) }}"
                placeholder="Slug generado">
            </flux:input>

            <!--FORMULARIO CATEGORIAS-->
            <flux:select label="Categorias" wire:model="categoria_id" placeholder="Selecciona una categoría...">
                @foreach ($categorias as $categoria)
                    <flux:select.option value="{{ $categoria->id }}"
                        :selected="$categoria->id == old('categoria_id', $entrada->categoria_id)">
                        {{ $categoria->nombre }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <!--FORMULARIO DESCRIPCION-->
            <flux:textarea label="Descripcion" name="descripcion" rows="4" resize="none">
                {{ old('descripcion', $entrada->descripcion) }}</flux:textarea>

            <!--BOTON ACTUALIZAR Entrada-->
            <div class="flex justify-end mt-3">
                <flux:button type="submit" variant="primary">Editar Entrada</flux:button>
            </div>
        </div>
    </form>
</x-layouts.app>
