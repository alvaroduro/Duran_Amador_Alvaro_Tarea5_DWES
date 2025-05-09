<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs class="mb-1">
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.usuarios.index') }}">Usuarios</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Editar Usuario</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="card">
        <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Vista previa del avatar actual (si existe) -->
            <label for="Imagen">Cambiar Avatar</label>
            <img class="w-35 h-15 object-cover object-center shadow-md" 
            src="{{ $usuario->avatar ? Storage::url($usuario->avatar) : '/img/noimage.jpeg' }}" 
            alt="Avatar">

            <!-- Avatar -->
            <div class="space-y-2">
                <flux:input type="file" label="Avatar" name="avatar" />
            </div>

            <!--FORMULARIO Nombre-->
            <flux:input label="Nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" placeholder="Introduce el nombre" />

            <!--FORMULARIO Apellidos-->
            <flux:input label="Apellidos" name="apellidos" value="{{ old('apellidos', $usuario->apellidos) }}" placeholder="Introduce los apellidos" />

            <!--FORMULARIO Nick-->
            <flux:input label="Nick" name="nick" value="{{ old('nick', $usuario->nick) }}" placeholder="Introduce el nick" />

            <!--FORMULARIO Email-->
            <flux:input type="email" label="Email" name="email" value="{{ old('email', $usuario->email) }}" placeholder="Introduce el email" />

            <!-- Campo de confirmación de contraseña -->
            <!-- Contraseña Actual-->
            <flux:field label="Contraseña actual" for="current_password">
                <label for="password_actual" class="block text-sm font-medium text-gray-700">Contraseña actual</label>
                <input type="password" name="password_actual" id="password_actual" class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Introduce tu contraseña actual">
            </flux:field>
            @error('password_actual')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

            <!-- Nueva Contraseña -->
            <flux:field label="Nueva Contraseña" for="password">
                <label for="password" class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
                <input type="password" name="password" id="password" class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Introduce una nueva contraseña">
            </flux:field>
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

            <!-- Confirmar Contraseña -->
            <flux:field label="Confirmar nueva contraseña" for="password_confirmation">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar nueva contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
                        <input type="radio" name="rol" value="admin" class="form-radio text-blue-600" {{ old('rol', $usuario->rol) === 'admin' ? 'checked' : '' }}>
                        <span>admin</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="rol" value="user" class="form-radio text-blue-600" {{ old('rol', $usuario->rol) === 'user' ? 'checked' : '' }}>
                        <span>user</span>
                    </label>
                </div>
            </flux:field>

            <div class="flex justify-end mt-3">
                <flux:button type="submit" variant="primary">Actualizar Usuario</flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>
