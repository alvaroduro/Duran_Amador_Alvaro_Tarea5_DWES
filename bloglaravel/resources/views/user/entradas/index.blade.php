<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('home') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Entradas</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <!--Boton nueva categoria-->
        <a href="{{ route('user.entradas.create') }}" class="btn btn-blue text-xs">Nueva Entrada</a>
    </div>

    <!--TABLA DE ENTRADAS-->
    <div class="relative overflow-x-auto mb-3">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        TITULO
                    </th>
                    <th scope="col" class="px-6 py-3 hidden">
                        SLUG
                    </th>
                    <th scope="col" class="px-6 py-3">
                        DESCRIPCION
                    </th>
                    <th scope="col" class="px-6 py-3">
                        IMAGEN
                    </th>
                    <th scope="col" class="px-6 py-3">
                        CATEGORIA
                    </th>
                    <th scope="col" class="px-6 py-3">
                        FECHA PUBLICACION
                    </th>
                    <th scope="col" class="px-6 py-3" width="10px">
                        OPERACIONES
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entradas as $entrada)
                    <!-- FILA CATEGORIA -->
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $entrada->id }}
                        </th>
                        <!-- COLUMNAS CATEGORIAS DATOS -->
                        <td class="px-6 py-4 max-w-xs break-words whitespace-normal">
                            {{ $entrada->titulo }}
                        </td>
                        <td class="px-6 py-4 hidden">
                            {{ $entrada->slug }}
                        </td>
                        <td class="px-6 py-4 max-w-xs break-words whitespace-normal">
                            {!! $entrada->descripcion !!}
                        </td>
                        <td class="px-6 py-4">
                            @if($entrada->imagen && file_exists(public_path('storage/' . $entrada->imagen)))
                                <img src="{{ asset('storage/' . $entrada->imagen) }}" alt="" width="50" height="50" />
                            @else
                                <img src="{{ asset('img/noimage.jpeg') }}" alt="Sin imagen" width="50" height="50" />
                            @endif
                       </td>
                        <td class="px-6 py-4">
                            {{ $entrada->categoria->nombre }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $entrada->fecha_publicacion }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">

                                <!-- Boton EDITAR categoria -->
                                <a class="btn btn-blue rounded-1 text-xs"
                                    href="{{ route('user.entradas.edit', $entrada) }}">Editar</a>

                                <!-- Boton ELIMINAR categoria -->
                                <form class="delete-form" action="{{ route('user.entradas.destroy', $entrada) }}"
                                    method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-red rounded-1 text-xs"
                                        href="{{ route('user.entradas.destroy', $entrada) }}">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- PAGINACION -->
    <div class="mt-4">
        {{ $entradas->links() }}   
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