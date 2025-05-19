<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Traemos todas las categorias:
        $categorias = Categoria::orderby('id', 'desc')->get();

        //Mostramos vista
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Mostramos vista para creacion de una nueva categoria
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Insertar una nueva categoria
        //Validaciones- guardamos el valor a añadir
        $datos = $request->validate([
            'nombre' => 'required|string|min:1|max:255|unique:categorias',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'nombre.min' => 'El nombre no puede tener menos de 1 caractere.',
            'nombre.unique' => 'Ya existe una categoría con ese nombre.',
        ]);

        //Guardamos la categoria
        Categoria::create($datos);

        //Variable de si la categoria se ha creado correctamente
        session()->flash('swa1', [
            'icon' => 'success',
            'tittle' => 'Bien hecho!',
            'text' => 'Categoria creada correctamente'
        ]);

        // Registrar log
        DB::statement("CALL insertar_log(?, ?)", [
            Auth::check() ? Auth::user()->email : 'Invitado',
            'Agregar categoria: ' . $datos['nombre']
        ]);

        //Redirigimos al listado de categorias
        return redirect()->route('admin.categorias.index')->with('success', 'Categoria creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        //Retornar vista de editar categoria
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        //Actuazlizamos la categoria
        //Validaciones- guardamos el valor a añadir
        $datos = $request->validate([
            'nombre' => 'required|string|min:1|max:255|unique:categorias',
        ],[
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'nombre.min' => 'El nombre no puede tener menos de 1 caractere.',
            'nombre.unique' => 'Ya existe una categoría con ese nombre.',
        ]);

        //Guardamos la categoria
        $categoria->update($datos);

        //Variable de si la categoria se ha creado correctamente
        session()->flash('swa1', [
            'icon' => 'success',
            'tittle' => 'Bien hecho!',
            'text' => 'Categoria: '.$categoria->nombre. ' editada correctamente'
        ]);

        //Redirigimos al listado de categorias
        return redirect()->route('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        //Elimnar categoria
        $categoria->delete();

        session()->flash('swa1', [
            'icon' => 'success',
            'tittle' => 'Bien hecho!',
            'text' => 'Categoría: ' . $categoria->nombre . ' eliminada correctamente'
        ]);

        return redirect()->route('admin.categorias.index');
    }
}
