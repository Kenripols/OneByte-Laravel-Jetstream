<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UpdateUserRequest;  // Asegúrate de importar el FormRequest
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtiene usuarios con paginación
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Implementar si quieres crear usuarios desde admin
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Implementar si usas creación desde admin
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Carga relaciones owner, pets y breeds para mostrar detalle
        $user = User::with('owner.pets.breed')->findOrFail($user->id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
{
    // Validamos y obtenemos los datos del Owner
    $validated = $request->validated();

    // Datos para Owner
    $ownerData = [
        'doctype' => $validated['doctype'],
        'docnum'  => $validated['docnum'],
        'fname'   => $validated['fname'],
        'fname2'  => $validated['fname2'] ?? null,
        'sname1'  => $validated['sname1'],
        'sname2'  => $validated['sname2'] ?? null,
    ];

    // Actualiza o crea el Owner relacionado
    $user->owner()->updateOrCreate(
        ['user_id' => $user->id],
        $ownerData
    );

    return redirect()->route('admin.users.index')
        ->with('success', 'Propietario actualizado correctamente');
}
    /**
     * Remove the specified resource from storage (borrado lógico).
     */
    public function destroy(User $user)
    {
        // Borrado lógico de mascotas relacionadas si usan SoftDeletes
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
                $pet->q_r_plates()->forceDelete(); // Borra QR plates asociados
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
    // Obtener sólo usuarios eliminados lógicamente con paginación
    $users = User::onlyTrashed()->paginate(10);

    // Retornar vista, podrías usar la misma vista con una bandera, o una vista distinta
    return view('admin.users.trashed', compact('users'));
}
public function restore($id)
{
    $user = User::onlyTrashed()->findOrFail($id);
    
    if ($user->owner) {
        $user->owner()->withTrashed()->restore(); // Restaura el owner
        $user->owner->pets()->withTrashed()->restore(); // Restaura las mascotas
    }

    $user->restore(); // Restaura el usuario

    return redirect()->route('admin.users.trashed')->with('success', 'Usuario restaurado correctamente.');
}
}

