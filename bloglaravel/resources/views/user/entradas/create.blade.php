<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('user.entradas.index') }}">Entradas</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Nueva Entrada</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="card">
        <form action="{{ route('user.entradas.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
            @csrf

            <!-- Imagen -->
            <div class="relative mb-2 w-full max-w-4xl mx-auto">

                <!-- Imagen de referencia por defecto -->
                <img id="imgPreview" class="w-full h-auto aspect-video object-cover object-center rounded-md shadow-md"
                    src="https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg" alt="img">

                <!-- Cambiar Imagen -->
                <div class="absolute top-4 right-4">
                    <label class="bg-white px-4 py-2 rounded-lg shadow cursor-pointer text-sm hover:bg-gray-100">
                        Cambiar Imagen
                        <input class="hidden" type="file" name="imagen" accept="image/*"
                            onchange="previewImage(event, '#imgPreview')">
                    </label>
                </div>
            </div>

            <!--FORMULARIO TITULO-->
            <flux:input label="Titulo" name="titulo" oninput="string_to_slug(this.value, '#slug')"
                value="{{ old('titulo') }}" placeholder="Escribe el título de la entrada">
            </flux:input>

            <!--FORMULARIO SLUG-->
            <flux:input label="Slug" name="slug" id="slug" value="{{ old('slug') }}"
                placeholder="Slug generado">
            </flux:input>

            <!--FORMULARIO CATEGORIAS-->
            <flux:select label="Categoría" name="categoria_id">
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </flux:select>

            <!--FORMULARIO DESCRIPCION-->
            <flux:textarea label="Descripcion" name="descripcion" rows="4" resize="none">
                {{ old('descripcion') }}</flux:textarea>


            <div class="flex justify-end mt-3">
                <flux:button type="submit" variant="primary">Crear Entrada</flux:button>
            </div>
        </form>
    </div>
    @push('js')
        <script>
            function previewImage(event, selector) {
                const input = event.target;
                const file = input.files[0];
                const preview = document.querySelector(selector);

                if (file && preview) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        </script>
    @endpush
</x-layouts.app>
