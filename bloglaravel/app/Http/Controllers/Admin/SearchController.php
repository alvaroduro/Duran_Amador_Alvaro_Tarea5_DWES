<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Entrada;

class SearchController extends Controller
{
    // Método del controlador para buscar entradas (usuarios en este caso)
    public function buscar(Request $request)
    {
        // Se obtiene el término que el usuario ha escrito en el input de búsqueda (viene por AJAX)
        $term = $request->input('term');

        // Se buscan los usuarios cuyo nombre contenga el término buscado (no distingue mayúsculas/minúsculas en MySQL)
        $querys = User::where('nombre', 'LIKE', '%' . $term . '%')->get();

        // Array que se devolverá como respuesta en formato JSON
        $data = [];

        // Se recorren los resultados encontrados
        foreach ($querys as $query) {
            // Se agregan los datos necesarios a cada resultado:
            // 'label' se usa para mostrar en la lista de sugerencias de jQuery UI
            // 'value' se escribe en el input si el usuario selecciona ese resultado
            // 'id' puede usarse si necesitas saber el ID del usuario seleccionado (opcional)
            $data[] = [
                'label' => $query->nombre,
                'value' => $query->nombre,
                'id' => $query->id,
            ];
        }

        // Se devuelve el array como respuesta JSON al cliente
        return response()->json($data);
    }

    // Método para autocompletar entradas (posts) según su título
    public function buscarEntradas(Request $request)
    {
        // Se obtiene el término que el usuario ha escrito en el input de búsqueda
        $term = $request->input('term');

        // Se buscan las entradas cuyo título contenga el término (LIKE %term%)
        $posts = Entrada::where('titulo', 'LIKE', '%' . $term . '%')->get();

        $data = [];

        // Se recorren los resultados y se preparan para el autocompletado
        foreach ($posts as $post) {
            $data[] = [
                'label' => $post->titulo, // lo que se muestra como sugerencia
                'value' => $post->titulo, // lo que se coloca en el input al seleccionar
                'id' => $post->id,        // ID por si se quiere usar
            ];
        }

        // Se devuelven los resultados como JSON
        return response()->json($data);
    }
}
