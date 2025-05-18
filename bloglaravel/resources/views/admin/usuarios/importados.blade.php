<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('home') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.usuarios.index') }}">Usuarios</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Importar Usuarios</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <h2 class="text-lg font-semibold mb-4">Usuarios válidos para insertar</h2>

    @if(count($usuarios) > 0)
    <table class="w-full mb-4 text-sm text-left text-gray-500">
        <thead class="bg-gray-700 text-white">
            <tr>
                <th class="px-4 py-2">Nick</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Apellidos</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Password</th>
                <th class="px-4 py-2">Avatar</th>
                <th class="px-4 py-2">Rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr class="bg-gray-800 text-white">
                    <td class="px-4 py-2">{{ $usuario['nick'] }}</td>
                    <td class="px-4 py-2">{{ $usuario['nombre'] }}</td>
                    <td class="px-4 py-2">{{ $usuario['apellidos'] }}</td>
                    <td class="px-4 py-2">{{ $usuario['email'] }}</td>
                    <td class="px-4 py-2">{{ Hash::make($usuario['password']) }}</td>
                    <td class="px-4 py-2">{{ $usuario['avatar'] }}</td>
                    <td class="px-4 py-2">{{ $usuario['rol'] }}</td>
                    <input type="hidden" name="{{$usuario['password']}}" value="{{ $usuario['password'] }}">
                </tr>
            @endforeach
        </tbody>
    </table>

    <form method="POST" action="{{ route('admin.guardarImportados') }}">
        @csrf
        <button type="submit" class="btn btn-blue">Guardar Usuarios</button>
    </form>
    @else
        <p>No hay usuarios válidos para guardar.</p>
    @endif

    @if (!empty($errores))
    <h2 class="text-lg font-semibold mt-8 mb-4 text-red-600">Usuarios con errores</h2>
    <table class="w-full mb-4 text-sm text-left text-red-700">
        <thead class="bg-red-700 text-white">
            <tr>
                <th class="px-4 py-2">Fila</th>
                <th class="px-4 py-2">Nick</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Apellidos</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Password</th>
                <th class="px-4 py-2">Avatar</th>
                <th class="px-4 py-2">Rol</th>
                <th class="px-4 py-2">Errores</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuariosConErrores as $index => $usuario)
                <tr class="bg-red-100 text-red-700">
                    <td class="px-4 py-2">{{ $index + 2 }}</td>
                    <td class="px-4 py-2">{{ $usuario['nick'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $usuario['nombre'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $usuario['apellidos'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $usuario['email'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ Hash::make($usuario['password']) ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $usuario['avatar'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $usuario['rol'] ?? '-' }}</td>
                    <td class="px-4 py-2">
                        <ul class="list-disc list-inside">
                            @foreach ($errores[$index] as $mensaje)
                                <li>{{ $mensaje }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Formulario para volver a importar Excel --}}
    <h3 class="text-md font-medium mb-2">Volver a importar un nuevo archivo</h3>
    <form action="{{ route('admin.importar') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2 mb-6">
        @csrf
        <input type="file" name="archivo" class="text-sm text-white bg-slate-700 p-1 rounded" required>
        <button type="submit" class="btn btn-blue rounded-1 text-xs">Importar Excel Usuarios</button>
    </form>

    {{-- Errores al subir el archivo --}}
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @endif
</x-layouts.app>
