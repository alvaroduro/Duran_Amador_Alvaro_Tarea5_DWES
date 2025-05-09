<x-layouts.app>

    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Usuarios</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <!--Boton nueva categoria-->
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-blue text-xs">Nuevo Usuario</a>

    </div>

    <!--TABLA USUARIOS-->
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        NICK
                    </th>
                    <th scope="col" class="px-6 py-3">
                        NOMBRE
                    </th>
                    <th scope="col" class="px-6 py-3">
                        APELLIDOS
                    </th>
                    <th scope="col" class="px-6 py-3">
                        EMAIL
                    </th>
                    <th scope="col" class="px-6 py-3">
                        AVATAR
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ROL
                    </th>
                    <th scope="col" class="px-6 py-3" width="10px">
                        OPERACIONES
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $user)
                    <!-- FILA CATEGORIA -->
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->id }}
                        </th>
                        <!-- COLUMNAS CATEGORIAS DATOS -->
                        <td class="px-6 py-4">
                            {{ $user->nick }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->nombre }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->apellidos }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->avatar }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->rol }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">

                                <!-- Boton EDITAR categoria -->
                                <a class="btn btn-blue rounded-1 text-xs"
                                    href="{{ route('admin.usuarios.edit', $user) }}">Editar</a>

                                <!-- Boton ELIMINAR categoria -->
                                <form class="delete-form" action="{{ route('admin.usuarios.destroy', $user) }}"
                                    method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-red rounded-1 text-xs"
                                        href="{{ route('admin.usuarios.destroy', $user) }}">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @push('js')
        <script>
            //Seleccionamos todos los formularios de eliminar
            forms = document.querySelectorAll('.delete-form');
            //Recorremos todos los formularios  
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    //Evitar el comportamiento por defecto del formulario
                    e.preventDefault();

                    //Mostramos la alerta de confirmacion
                    Swal.fire({
                        title: '¿Estás seguro que deseas eliminar?',
                        text: "No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar!',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //Si el usuario confirma, enviamos el formulario
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
</x-layouts.app>