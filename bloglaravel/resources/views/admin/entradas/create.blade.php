<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('home') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.entradas.index') }}">Entradas</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Nueva Entrada</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="card">
        <form action="{{ route('admin.entradas.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
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
                value="{{ old('titulo') }}" placeholder="Escribe el título de la entrads">
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

            <!--FORMULARIO USUARIOS-->
            <flux:select label="Usuario" name="user_id">
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
                @endforeach
            </flux:select>

            <!--FORMULARIO DESCRIPCION-->
            {{-- <flux:textarea label="Descripcion" name="descripcion" rows="4" resize="none">
                {{ old('descripcion') }}</flux:textarea> --}}
                <div>
                    <p class="font-medium text-sm mb-1">
                        Descripción
                    </p>
                    <div id="editor">{!!old('descripcion')!!}</div>

                    <textarea class="hidden" name="descripcion" id="descripcion"></textarea>
                </div>

            <flux:button class="flex justify-end mt-3" type="submit" variant="primary">Crear Entrada</flux:button>
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
        <!-- Include the Quill library -->
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    
        <!-- Initialize Quill editor -->
        <script>
            const quill = new Quill('#editor', {
                theme: 'snow'
            });

            //Escuchamos un evento para el texto enriquecido
            quill.on('text-change', function() {
                document.querySelector('#descripcion').value = quill.root.innerHTML;
            })
        </script>
    @endpush
</x-layouts.app>
