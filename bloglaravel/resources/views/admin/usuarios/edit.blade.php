<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs class="mb-1">
            <flux:breadcrumbs.item href="{{ route('home') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.usuarios.index') }}">Usuarios</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Editar Usuario</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="card">
        <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST" class="space-y-4"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Vista previa del avatar actual (si existe) -->
            <!--Imagen-->
            <div class="relative mb-2 w-full max-w-4xl mx-auto">

                <!--Cogemos l url que nos genera el paquete-->
                <img id="imgPreview" class="w-50 h-50 rounded-full object-cover border-4 border-gray-300 shadow-md mx-auto"
                    src=" {{ $usuario->avatar ? Storage::url($usuario->avatar) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg' }}"
                    alt="avatar">

                <!-- Cambiar Imagen -->
                <div class="absolute top-4 right-4">
                    <label class="bg-white px-4 py-2 rounded-lg shadow cursor-pointer text-sm hover:bg-gray-100">
                        Cambiar Avatar
                        <input class="hidden" type="file" name="avatar" accept="image/*"
                            onchange="previewImage(event, '#imgPreview')">
                    </label>
                </div>
            </div>

            <!--FORMULARIO Nombre-->
            <flux:input label="Nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}"
                placeholder="Introduce el nombre" />

            <!--FORMULARIO Apellidos-->
            <flux:input label="Apellidos" name="apellidos" value="{{ old('apellidos', $usuario->apellidos) }}"
                placeholder="Introduce los apellidos" />

            <!--FORMULARIO Nick-->
            <flux:input label="Nick" name="nick" value="{{ old('nick', $usuario->nick) }}"
                placeholder="Introduce el nick" />

            <!--FORMULARIO Email-->
            <flux:input type="email" label="Email" name="email" value="{{ old('email', $usuario->email) }}"
                placeholder="Introduce el email" />

            <!-- Campo de confirmación de contraseña -->
            <!-- Contraseña Actual-->
            <flux:field label="Contraseña actual" for="current_password">
                <label for="password_actual" class="block text-sm font-medium text-gray-700">Contraseña actual</label>
                <input type="password" name="password_actual" id="password_actual"
                    class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Introduce tu contraseña actual">
            </flux:field>
            @error('password_actual')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

            <!-- Nueva Contraseña -->
            <flux:field label="Nueva Contraseña" for="password">
                <label for="password" class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
                <input type="password" name="password" id="password"
                    class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Introduce una nueva contraseña">
            </flux:field>
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

            <!-- Confirmar Contraseña -->
            <flux:field label="Confirmar nueva contraseña" for="password_confirmation">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar nueva
                    contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Confirma tu nueva contraseña">
            </flux:field>
            @error('password_confirmatio')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror



            <!--FORMULARIO Rol-->
            <!-- Selector de Rol en estilo Flux -->
            <flux:field label="Rol" for="rol">
                <div class="flex items-center gap-6 mt-2">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="rol" value="admin" class="form-radio text-blue-600"
                            {{ old('rol', $usuario->rol) === 'admin' ? 'checked' : '' }}>
                        <span>admin</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="rol" value="user" class="form-radio text-blue-600"
                            {{ old('rol', $usuario->rol) === 'user' ? 'checked' : '' }}>
                        <span>user</span>
                    </label>
                </div>
            </flux:field>

            <div class="flex justify-end mt-3">
                <flux:button type="submit" variant="primary">Actualizar Usuario</flux:button>
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
