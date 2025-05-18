<x-layouts.app>

    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('home') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Usuarios</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <a href="{{ route('admin.usuarios.pdf') }}" target="_blank" class="btn btn-green text-xs">Exportar PDF</a>

        <!--Boton nueva categoria-->
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-blue text-xs">Nuevo Usuario</a>

    </div>

    <!--Formulario de busqueda usuarios por nombre-->
    <form action="" class="flex justify-center mt-10 mb-4">
        <div class="flex w-full max-w-md bg-slate-800 rounded-xl overflow-hidden shadow-lg">
            <input type="text"
                class="flex-1 px-4 py-2 bg-slate-900 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-500"
                placeholder="Buscar Usuarios" name="search" id="search" aria-label="Search" />
            <button type="button" id="btn-buscar"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm font-semibold transition-all">
                Buscar
            </button>

        </div>
    </form>

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
                            @if($user->avatar && file_exists(public_path('storage/' . $user->avatar)))
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="" width="50" height="50" />
                            @else
                                <img src="{{ asset('img/noimage.jpeg') }}" alt="Sin imagen" width="50" height="50" />
                            @endif
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
                                <a class="btn btn-purple rounded-1 text-xs"
                                    href="{{ route('admin.usuarios.show', $user) }}">
                                    Detalle
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- PAGINACION -->
    <div class="mt-4">
        {{ $usuarios->appends(['buscar' => request('buscar')])->links() }}
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
        <script src="{{ asset('vendor/jquery-ui/jquery-ui-1.14.1/jquery-ui.min.js') }}"></script>
        <script>
            // Cuando se carga la página, se activa el autocompletado en el input con id "search"
            $('#search').autocomplete({
                // source define cómo se van a obtener los resultados del autocompletado
                source: function(request, response) {
                    // Se hace una petición AJAX al servidor para buscar coincidencias
                    $.ajax({
                        url: "{{ route('admin.usuarios.buscar') }}", // Ruta que devuelve los datos (en formato JSON)
                        data: {
                            term: request.term // Se envía lo que el usuario está escribiendo en el input
                        },
                        dataType: "json", // Se espera una respuesta en formato JSON
                        success: function(data) {
                            // Si la petición es exitosa, se ejecuta esta función
                            // 'data' debe ser un array de objetos con propiedades 'label' y 'value'
                            response(data); // Se muestran los resultados en la lista de autocompletado
                        }
                    });
                },
                // select se ejecuta cuando el usuario selecciona una opción de la lista
                select: function(event, ui) {
                    // Redirige a la página de resultados, agregando el valor seleccionado en la URL como parámetro de búsqueda
                    window.location.href = "{{ route('admin.usuarios.index') }}" + "?search=" + ui.item.value;
                }
            });
        
            // Si el usuario hace clic en el botón con id "btn-buscar"
            $('#btn-buscar').on('click', function() {
                // Se obtiene el valor escrito en el input de búsqueda
                const valor = $('#search').val();
                // Se redirige a la página de resultados con el parámetro search en la URL
                window.location.href = "{{ route('admin.usuarios.index') }}" + "?search=" + valor;
            });
        </script>
        
    @endpush
</x-layouts.app>