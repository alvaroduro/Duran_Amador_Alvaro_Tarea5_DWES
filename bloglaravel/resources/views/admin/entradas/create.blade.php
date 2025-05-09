<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.entradas.index') }}">Entradas</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Nueva Entrada</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="card">
        <form action="{{ route('admin.entradas.store') }}" method="POST" class="space-y-4">
            @csrf
            
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
            <flux:textarea label="Descripcion" name="descripcion" rows="4" resize="none">
                {{ old('descripcion') }}</flux:textarea>

            <!-- Input de archivo -->
            <img id="avatarPreview" class="w-24 h-24 object-cover object-center rounded-full shadow-md mb-4"
                src="{{ old('avatar') ? Storage::url(old('avatar')) : asset('/img/noimage.jpeg') }}" alt="avatar" />

            <!-- Input de archivo -->
            <flux:input type="file" label="Avatar" name="avatar" onchange="previewAvatar(event)" />
            <div class="flex justify-end mt-3">
                <flux:button type="submit" variant="primary">Crear Entrada</flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>
