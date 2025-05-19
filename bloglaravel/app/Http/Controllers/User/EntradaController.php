<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Entrada;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Trae las entradas del usuario autenticado
        $entradas = Entrada::where('user_id', Auth::id())->paginate();
        return view('user.entradas.index', compact('entradas'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Nos traemos los datos
        $usuarios = User::all();
        $categorias = Categoria::all();

        //Creacion de un nuevo Entrada
        return view('user.entradas.create', compact('usuarios', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos del formulario
        $datos = $request->validate([
            'titulo' => 'required|string|min:1|max:191',
            'slug' => 'required|string|min:1|max:191|unique:entradas,slug',
            'descripcion' => 'nullable|string',
            'contenido' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048',
        ], [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.max' => 'El titulo no puede tener más de 191 caracteres.',
            'titulo.min' => 'El titulo no puede tener menos de 1 caracter.',
            'slug.required' => 'El slug es obligatorio.',
            'slug.unique' => 'El slug ya está en uso.',
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'imagen.image' => 'La imagen no cumple el formato adecuado.',
        ]);

        // Agregamos la fecha de publicación (fecha actual)
        $datos['fecha_publicacion'] = now(); // Establece la fecha de publicación a la fecha y hora actuales

        //Nos traemos el id del usuario
        $datos['user_id'] = \Illuminate\Support\Facades\Auth::user()->id;

        //Comprobamos si se esta adjuntando la imagen
        if ($request->hasFile('imagen')) {

            //Subimos la imagen al servidor y guardamos la ruta
            $datos['imagen'] = Storage::put('entradas', $request->imagen);
        }

        // Guardamos la entrada
        $entrada = Entrada::create($datos);

        // Mensaje de éxito sweetalert
        session()->flash('swa1', [
            'icon' => 'success',
            'tittle' => '¡Bien hecho!',
            'text' => 'Entrada "' . $entrada->titulo . '" creada correctamente.'
        ]);

        // Redirigimos a la edición de la entrada
        return redirect()->route('user.entradas.index', $entrada);
    }

    /**
     * Display the specified resource.
     */
    public function show(Entrada $entrada)
    {
        return view('admin.usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entrada $entrada)
    {
        //Nos traemos los datos
        $usuarios = User::all();
        $categorias = Categoria::all();

        //Creacion de un nuevo Entrada
        return view('user.entradas.edit', compact('entrada', 'usuarios', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entrada $entrada)
    {
        // Validación de los campos del formulario
        $datos = $request->validate([
            'titulo' => 'required|string|min:1|max:191',
            'slug' => 'required|string|min:1|max:191|unique:entradas,slug,' . $entrada->id, // Evita conflicto con el slug del mismo Entrada
            'categoria_id' => 'required|exists:categorias,id',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image', // Validación de imagen opcional
        ], [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.string' => 'El título debe ser una cadena de texto.',
            'titulo.max' => 'El título no puede tener más de 191 caracteres.',
            'titulo.min' => 'El título no puede tener menos de 1 carácter.',
            'slug.required' => 'El slug es obligatorio.',
            'slug.unique' => 'El slug ya existe.',
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'imagen.image' => 'Debe ser una imagen válida.',
        ]);

        // Agregamos la fecha de publicación (fecha actual)
        $datos['fecha_publicacion'] = now(); // Establece la fecha de publicación a la fecha y hora actuales

        //Comprobamos si se esta adjuntando la imagen
        if ($request->hasFile('imagen')) {

            //Comprobamos si hay una imagen anterior
            if ($entrada->imagen) {
                Storage::delete($entrada->imagen);
            }

            //Subimos la imagen al servidor
            $datos['imagen'] = Storage::put('entradas', $request->imagen);
        }


        // Actualizamos los datos de la entrada
        $entrada->update($datos);

        // Mostramos un mensaje de éxito
        session()->flash('swa1', [
            'icon' => 'success',
            'tittle' => '¡Bien hecho!',
            'text' => 'La entrada "' . $entrada->titulo . '" se actualizó correctamente.'
        ]);

        // Redirigimos a la página de edición de la entrada
        return redirect()->route('user.entradas.edit', $entrada);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entrada $entrada)
    {
        //Elimnar cEntrada
        $entrada->delete();

        session()->flash('swa1', [
            'icon' => 'success',
            'tittle' => 'Bien hecho!',
            'text' => 'Entrada: ' . $entrada->nombre . ' eliminada correctamente'
        ]);

        // Registrar log
      DB::statement("CALL insertar_log(?, ?)", [
        Auth::check() ? Auth::user()->email : 'Invitado',
        'Elimnar entrada: ' . $entrada->titulo,
    ]);

        return redirect()->route('user.entradas.index');
    }
}
