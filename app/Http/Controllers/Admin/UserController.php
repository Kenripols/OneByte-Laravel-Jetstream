<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Mostrar una lista del recurso.
     */
    public function index()
    {
        //Devuelve la vista del index de usuarios
        // Paginamos los resultados
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        //
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(User $user)
    {
        // Carga relaciones owner, pets y breeds para mostrar detalle
        $user = User::with('owner.pets.breed')->findOrFail($user->id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(User $user)
    {

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualice el recurso especificado en el almacenamiento.
     */
    public function update(UpdateUserRequest $request, User $user)
{
    // Validamos y obtenemos los datos del Owner
    $validated = $request->validated();

    // Datos para Owner
    $ownerData = [
        'docType' => $validated['docType'],
        'docNum'  => $validated['docNum'],
        'fName1'   => $validated['fName1'],
        'fName2'  => $validated['fName2'] ?? null,
        'sName1'  => $validated['sName1'],
        'sName2'  => $validated['sName2'] ?? null,
    ];

    // Actualiza o crea el Owner relacionado ?? Consultar con Equis
    $user->owner()->updateOrCreate(
        ['user_id' => $user->id],
        $ownerData
    );

    return redirect()->route('admin.users.index')
        ->with('success', 'Dueño actualizado correctamente');
}
    /**
     * Elimina el recurso especificado del almacenamiento. (borrado lógico).
     */
    public function destroy(User $user)
    {
        // Borrado lógico de mascotas relacionadas con el uso de SoftDeletes
        if ($user->owner) {
            $user->owner->pets()->delete();
            $user->owner->delete();
        }

        // Borrado lógico usuario
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente (borrado lógico)');
    }

    /**
     * Borrado físico: elimina usuario y datos relacionados físicamente.
     */
    public function forceDelete(User $user)
    {
        if ($user->owner) {
            foreach ($user->owner->pets as $pet) {
                $pet->q_r_plates()->forceDelete(); // Borra Placas QR asociadas a mascotas
            }
            $user->owner->pets()->forceDelete(); // Borra mascotas
            $user->owner->forceDelete();         // Borra owner
        }
        $user->forceDelete(); // Borra usuario

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado físicamente junto con sus datos relacionados');
    }

    /**
     * Vista para confirmar eliminación lógica.
     */
    public function confirmDelete(User $user)
    {
        return view('admin.users.confirm-delete', compact('user'));
    }

    /**
     * Vista para confirmar eliminación física.
     */
    public function confirmForceDelete(User $user)
    {
        return view('admin.users.confirm-force-delete', compact('user'));
    }
public function trashed()
{
    // Obtengo sólo usuarios eliminados lógicamente con paginación
    $users = User::onlyTrashed()->paginate(10);

    // Retornar vista, podrías usar la misma vista con una bandera, o una vista distinta
    return view('admin.users.trashed', compact('users'));
}
public function restore($id)
{
    $user = User::onlyTrashed()->findOrFail($id);

    // Restauro el usuario primero
    $user->restore();

    // Restauro el perfil de owner y sus mascotas si tiene
    if ($user->owner()->withTrashed()->exists()) {
        $owner = $user->owner()->withTrashed()->first();
        $owner->restore();

        // Restauro sus mascotas
        $owner->pets()->withTrashed()->restore();
    }

    return redirect()->route('admin.users.trashed')->with('success', 'Usuario restaurado correctamente.');
}
}

