<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQRPlateRequest;
use App\Models\QRPlate;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QRPlateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   // Si el usuario es owner mostrar solo los QR de sus mascotas
        if (Auth::user()->hasRole('owner')) {
            $QRPlates = QRPlate::whereHas('pet', function ($query) {
                $query->where('owner_id', Auth::id());
            })->paginate(10); // Paginación de 10
            return view('owner.qrplates.index', compact('QRPlates'));
        }
        // Si el usuario es admin mostrar todos los QR
        if (Auth::user()->hasRole('admin')) {
            $QRPlates = QRPlate::paginate(10); 
            return view('admin.qrplates.index', compact('QRPlates'));
        }
        // Default: empty collection
        return view('admin.qrplates.index', ['QRPlates' => collect()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Si el usuario es owner, redirigir a la vista de crear QR para mascotas
        if (Auth::user()->hasRole('owner')) {
            $pets = Pet::with(['breed', 'owner'])
                ->whereHas('owner', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->paginate(10);
            return view('owner.qrplates.create', compact('pets'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQRPlateRequest $request)
    {
        // Validación y almacenamiento del QRPlate
        $request->validated();
        // Creo el nuevo QRPlate
        $qRPlate = new QRPlate();
        $qRPlate->pet_id = $request->pet_id;
        $qRPlate->code = $request->code;
        $qRPlate->iDate = $request->iDate;
        $qRPlate->eDate = $request->eDate;
        $qRPlate->save();

        return redirect()->route('owner.qrplates.index')->with('success', 'La placa QR ha sido creada.');
    }

    /**
     * Display the specified resource.
     */
    public function show(QRPlate $qRPlate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QRPlate $qRPlate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QRPlate $qRPlate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QRPlate $qRPlate)
    {
        //
    }
}
