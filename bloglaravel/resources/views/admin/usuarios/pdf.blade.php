<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listado de Entradas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2 class="text-center">Listado de Entradas</h2>

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
                    <img src="{{ public_path('storage/' . $user->avatar) }}" width="50" height="50" />
                    @else
                    <img src="{{ public_path('img/noimage.jpeg') }}" width="50" height="50" />
                    @endif
                </td>
                <td class="px-6 py-4">
                    {{ $user->rol }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>