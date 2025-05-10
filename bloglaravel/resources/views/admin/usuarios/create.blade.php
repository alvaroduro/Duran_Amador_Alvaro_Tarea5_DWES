<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs class="mb-2">
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.usuarios.index') }}">Usuarios</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Nuevo Usuario</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <!--Formulario Creacion Usuario-->
    <div class="card">
        <form action="{{ route('admin.usuarios.store') }}" method="POST" class="space-y-3" enctype="multipart/form-data">
            @csrf
            <flux:input label="Nombre" name="nombre" value="{{ old('nombre') }}"
                placeholder="Escribe el nombre del usuario">
            </flux:input>

            <flux:input label="Apellidos" name="apellidos" value="{{ old('apellidos') }}"
                placeholder="Escribe los apellidos del usuario">
            </flux:input>

            <flux:input label="Nick" name="nick" value="{{ old('nick') }}"
                placeholder="Escribe el nick del usuario">
            </flux:input>

            <flux:input label="Email" name="email" value="{{ old('email') }}"
                placeholder="Escribe el email del usuario">
            </flux:input>

            <!-- Imagen Avatar-->
            <div class="relative mb-2 w-full max-w-4xl mx-auto">

                <!-- Imagen de referencia por defecto -->
                <img id="imgPreview" class="w-50 h-50 rounded-full object-cover border-4 border-gray-300 shadow-md mx-auto"
                    src="https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg" alt="avatar">

                <!-- Cambiar Imagen -->
                <div class="absolute top-4 right-4">
                    <label class="bg-white px-4 py-2 rounded-lg shadow cursor-pointer text-sm hover:bg-gray-100">
                        Cambiar Avatar
                        <input class="hidden" type="file" name="avatar" accept="image/*"
                            onchange="previewImage(event, '#imgPreview')">
                    </label>
                </div>
            </div>

            <flux:input type="password" label="Contraseña" name="password"
                placeholder="Escribe la contraseña del usuario">
            </flux:input>

            <flux:input type="password" label="Confirmar Contraseña" name="password_confirmation"
                placeholder="Confirma la contraseña del usuario">
            </flux:input>

            <flux:input type="hidden" name="rol" value="user">
            </flux:input> <!-- Aquí añadimos el campo oculto para el rol -->

            <div class="flex justify-end mt-3">
                <flux:button type="submit" variant="primary">Crear Usuario</flux:button>
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
