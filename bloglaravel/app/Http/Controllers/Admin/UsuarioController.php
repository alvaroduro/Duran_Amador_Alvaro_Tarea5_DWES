<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Imports\UsuariosImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Se obtiene el texto de búsqueda desde la URL (?search=algo)
        $search = $request->input('search');

        // Se consultan los usuarios aplicando la búsqueda solo si hay texto introducido
        $usuarios = User::when($search, function ($query, $search) {
            // Si hay un término de búsqueda, se aplica un filtro en el campo 'nombre'
            return $query->where('nombre', 'LIKE', '%' . $search . '%');
        })
            ->orderBy('id', 'desc')  // Orden descendente por ID (muestra los últimos usuarios primero)
            ->paginate(5); // Se aplica paginación: muestra 5 usuarios por página

        // Se retorna la vista 'admin.usuarios.index' y se le pasa la variable $usuarios
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
            'avatar' => 'nullable|image|max:2048', // La URL o ruta del avatar puede ser nula
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

        //Comprobamos si se esta adjuntando la imagen
        if ($request->hasFile('avatar')) {

            //Subimos la imagen al servidor y guardamos la ruta
            $datos['avatar'] = Storage::put('users', $request->avatar);
        }

        // Guardar el usuario
        $usuario = User::create($datos);

        // Mensaje de éxito con SweetAlert
        session()->flash('swa1', [
            'icon' => 'success',
            'title' => '¡Usuario creado!',
            'text' => 'El usuario: ' . $usuario->nombre . ' ha sido creado correctamente.',
        ]);

        // Redirigimos a la edición de la entrada
        return redirect()->route('admin.usuarios.index', $usuario);
    }



    /**
     * Display the specified resource.
     */
    public function show(User $usuario)
    {
        $totalEntradas = $usuario->entradas()->count(); // Relación entradas del usuario

        return view('admin.usuarios.show', compact('usuario', 'totalEntradas'));
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

        //Comprobamos si se esta adjuntando la imagen
        if ($request->hasFile('avatar')) {

            //Comprobamos si hay una imagen anterior
            if ($usuario->avatar) {
                Storage::delete($usuario->avatar); //si hay algo la borramos
            }

            //Subimos la imagen al servidor y guardamos la ruta
            $datos['avatar'] = Storage::put('users', $request->avatar);
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


    /**
     * Exportar usuarios a PDF
     */
    public function exportarPdf()
    {
        $usuarios = User::orderby('id', 'desc')->get();

        $pdf = Pdf::loadView('admin.usuarios.pdf', compact('usuarios'));

        return $pdf->stream('usuarios.pdf'); // o download('archivo.pdf')
    }

    /**Metodo para importar archivos excel */
    public function importarExcel(Request $request)
    {
        $request->validate([
            'archivo' => 'required|mimes:xlsx,xls'
        ], [
            'archivo.mimes' => 'El formato no es el correcto.Debes ser un archivo Excel.',
        ]);

        try {
            $import = new UsuariosImport();
            Excel::import($import, $request->file('archivo'));

            session(['usuarios_importados' => $import->usuarios]);

            return view('admin.usuarios.importados', [
                'usuarios' => $import->usuarios
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['archivo' => $e->getMessage()]);
        }
    }

    public function vistaImportados()
    {
        $usuarios = Session::get('usuarios_importados', []);
        return view('admin.usuarios.importados', compact('usuarios'));
    }


    public function guardarImportados()
    {
        $usuarios = Session::get('usuarios_importados', []);
        $errores = [];
        $usuariosValidados = [];

        foreach ($usuarios as $index => $usuario) {
            // Asignar 'user' si no hay rol
            $usuario['rol'] = $usuario['rol'] ?? 'user';

            $validator = Validator::make($usuario, [
                'nick' => 'required|string|max:50|unique:users,nick',
                'nombre' => 'required|string|min:2|max:100',
                'apellidos' => 'nullable|string|max:100',
                'avatar' => 'nullable|string|max:255', // nombre del archivo (ya subido)
                'rol' => 'required|in:admin,user',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8',
            ], [
                'nick.required' => 'El nick es obligatorio.',
                'nick.unique' => 'El nick ya existe.',
                'nick.max' => 'El nick no debe superar los 50 caracteres.',
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
                'apellidos.max' => 'Los apellidos no deben superar los 100 caracteres.',
                'avatar.max' => 'El nombre del avatar es demasiado largo.',
                'rol.required' => 'El rol es obligatorio.',
                'rol.in' => 'El rol debe ser admin o user.',
                'email.required' => 'El email es obligatorio.',
                'email.email' => 'Formato de email no válido.',
                'email.unique' => 'Ya existe un usuario con ese email.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            ]);

            if ($validator->fails()) {
                $errores[$index] = $validator->errors()->all();
            } else {
                // Preparamos usuario con contraseña encriptada
                $usuarioValido = [
                    'nick' => $usuario['nick'],
                    'nombre' => $usuario['nombre'],
                    'apellidos' => $usuario['apellidos'] ?? '',
                    'avatar' => $usuario['avatar'] ?? null, // nombre del archivo (ej. juan.jpg)
                    'rol' => $usuario['rol'],
                    'email' => $usuario['email'],
                    'password' => Hash::make($usuario['password']),
                ];

                $usuariosValidados[] = $usuarioValido;
            }
        }

        // Mostrar errores si existen
        if (!empty($errores)) {
            return view('admin.usuarios.importados', [
                'usuarios' => $usuariosValidados,
                'errores' => $errores,
                'usuariosConErrores' => array_filter($usuarios, fn($key) => isset($errores[$key]), ARRAY_FILTER_USE_KEY),
            ]);
        }

        // Guardar los usuarios validados
        foreach ($usuariosValidados as $usuarioData) {
            User::create($usuarioData);
        }

        // Limpiar sesión
        Session::forget('usuarios_importados');

        // Mensaje flash de éxito
        session()->flash('swa1', [
            'icon' => 'success',
            'tittle' => '¡Bien hecho!',
            'text' => 'Usuarios agregados correctamente'
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuarios importados correctamente.');
    }
}
