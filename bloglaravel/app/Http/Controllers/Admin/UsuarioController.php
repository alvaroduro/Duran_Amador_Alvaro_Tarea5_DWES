<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Traemos todas las categorias:
        $usuarios = User::orderby('id', 'desc')->get();

        //Mostramos vista
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Mostramos vista para creacion de un nuevo user
        return view('admin.usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validación de los datos
        $datos = $request->validate([
            'nombre' => 'required|string|min:2|max:255',
            'apellidos' => 'required|string|min:2|max:255',
            'nick' => 'required|string|min:3|max:50|unique:users,nick',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'avatar' => 'nullable|string', // La URL o ruta del avatar puede ser nula
            'rol' => 'in:admin,user', // Validamos que el rol sea válido
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'nick.required' => 'El nick es obligatorio.',
            'nick.unique' => 'Ya existe un usuario con ese nick.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debes proporcionar un email válido.',
            'email.unique' => 'Ya existe un usuario con ese email.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'rol.in' => 'El rol debe ser válido.',
        ]);

        // Encriptar la contraseña antes de guardar
        $datos['password'] = bcrypt($datos['password']);

        // Guardar el usuario
        User::create($datos);

        // Mensaje de éxito con SweetAlert
        session()->flash('swa1', [
            'icon' => 'success',
            'title' => '¡Usuario creado!',
            'text' => 'El usuario ha sido creado correctamente.',
        ]);

        // Redirigir a la lista de usuarios
        return redirect()->route('admin.usuarios.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {
        //Retornar vista de editar usuarios
        return view('admin.usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $usuario)
    {

        // Validaciones
        $datos = $request->validate([
            'nombre' => 'required|string|min:1|max:191',
            'apellidos' => 'nullable|string|max:191',
            'nick' => 'required|string|min:3|max:50|unique:users,nick,' . $usuario->id,
            'email' => 'required|email|max:191|unique:users,email,' . $usuario->id,
            'rol' => 'required|in:admin,user',
            'avatar' => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
            'password_actual' => 'nullable|string|min:8',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nick.required' => 'El nick es obligatorio.',
            'nick.unique' => 'Ya existe un usuario con ese nick.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email no es válido.',
            'email.unique' => 'Ya existe un usuario con ese email.',
            'rol.required' => 'El rol es obligatorio.',
            'avatar.image' => 'El avatar debe ser una imagen.',
            'avatar.max' => 'El avatar no puede pesar más de 2MB.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password_actual.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);


        // Si se quiere cambiar la contraseña, verificar primero la actual
        if (!empty($request->password)) {

            if (empty($request->password_actual)) {
                return back()->withErrors(['password_actual' => 'Debes introducir la contraseña actual.'])->withInput();
            }

            if (!Hash::check($request->password_actual, $usuario->password)) {
                return back()->withErrors(['password_actual' => 'La contraseña actual no es correcta.'])->withInput();
            }

            $datos['password'] = bcrypt($request->password);
        } else {
            unset($datos['password']); // No se actualiza la contraseña
        }


        // Actualizamos el usuario solo si todo ha ido bien
        $usuario->update($datos);

        session()->flash('swa1', [
            'icon' => 'success',
            'tittle' => 'Usuario actualizado',
            'text' => 'Usuario: ' . $usuario->nombre . ' actualizado correctamente'
        ]);

        return redirect()->route('admin.usuarios.edit', $usuario);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        $nombre = $usuario->nombre; // Guarda el nombre antes

        $usuario->delete();

        session()->flash('swa1', [
            'icon' => 'success',
            'tittle' => 'Bien hecho!',
            'text' => 'Usuario: ' . $nombre . ' eliminado correctamente'
        ]);

        return redirect()->route('admin.usuarios.index');
    }
}
