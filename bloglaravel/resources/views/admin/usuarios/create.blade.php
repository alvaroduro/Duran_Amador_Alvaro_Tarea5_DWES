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
        <form action="{{ route('admin.usuarios.store') }}" method="POST" class="space-y-3">
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

            <!-- Input de archivo -->
            <img id="avatarPreview"
                class="w-24 h-24 object-cover object-center rounded-full shadow-md mb-4"
                src="{{ old('avatar') ? Storage::url(old('avatar')) : asset('/img/noimage.jpeg') }}"
                alt="avatar" />

            <!-- Input de archivo -->
            <flux:input type="file" label="Avatar" name="avatar" onchange="previewAvatar(event)" />

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
</x-layouts.app>

