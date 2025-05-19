<x-layouts.app>
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('home') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Logs</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <!-- Botón Exportar PDF -->
        <a href="{{ route('admin.logs.pdf') }}" target="_blank"
            class="btn btn-green text-xs px-4 py-2 rounded shadow hover:bg-green-600 transition-all">
            Exportar PDF
        </a>
    </div>


    <!--TABLA DE LOGS-->
    <div class="relative overflow-x-auto mb-3">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        FECHA
                    </th>
                    <th scope="col" class="px-6 py-3 hidden">
                        HORA
                    </th>
                    <th scope="col" class="px-6 py-3">
                        USUARIO
                    </th>
                    <th scope="col" class="px-6 py-3">
                        OPERACION
                    </th>
                    <th scope="col" class="px-6 py-3" width="10px">
                        OPERACIONES
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <!-- FILA CATEGORIA -->
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $log->id }}
                        </th>
                        <!-- COLUMNAS CATEGORIAS DATOS -->
                        <td class="px-6 py-4 max-w-xs break-words whitespace-normal">
                            {{ \Carbon\Carbon::parse($log->fecha)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 hidden">
                            {{ \Carbon\Carbon::parse($log->hora)->format('H:i') }}
                        </td>
                        <td class="px-6 py-4  max-w-xs break-words whitespace-normal">
                            {{ $log->usuario }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $log->operacion }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex space-x-2">

                                <!-- Boton ELIMINAR categoria -->
                                <form class="delete-form" action="{{ route('admin.logs.destroy', $log) }}"
                                    method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-red rounded-1 text-xs"
                                        href="{{ route('admin.logs.destroy', $log) }}">Eliminar</button>
                                    <!-- Boton EDITAR categoria -->
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
        {{ $logs->links() }}
    </div>
</x-layouts.app>
