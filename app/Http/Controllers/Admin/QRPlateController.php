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
    {   
            $QRPlates = QRPlate::paginate(10); 
            return view('admin.qrplates.index', compact('QRPlates'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return redirect()->route('admin.qrplates.index')
            ->with('error', 'No tienes permiso para crear placas QR.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQRPlateRequest $request)
    {
        return redirect()->route('admin.qrplates.index')
            ->with('error', 'No tienes permiso para crear placas QR.');
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
