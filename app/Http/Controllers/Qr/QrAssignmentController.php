<?php

namespace App\Http\Controllers\Qr;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\QrPlate;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QrAssignmentController extends Controller
{
    public function form()
    {
        $qrId = session('claimed_qr_id');

        if (!$qrId) {
            return redirect()->route('owner.dashboard');
        }

        $owner = Owner::where('user_id', auth()->id())->firstOrFail();

        $pets = Pet::where('owner_id', $owner->id)->get();

        // si no tiene mascotas -> crear directamente
        if ($pets->isEmpty()) {
            return redirect()->route('owner.pets.create');
        }

        return view('owner.qrplates.assign', compact('pets'));
    }

    // asignar a mascota existente
    public function assignToExisting(Request $request)
    {
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
        ]);

        $qr = QrPlate::findOrFail(session('claimed_qr_id'));

        $owner = Owner::where('user_id', auth()->id())->firstOrFail();

        $pet = Pet::where('id', $request->pet_id)
            ->where('owner_id', $owner->id)
            ->firstOrFail();

        // VALIDACIONES

        if ($qr->pet_id !== null) {
            return back()->with('error', 'El QR ya está asignado.');
        }

        if ($qr->status === QrPlate::STATUS_GENERATED) {
            return back()->with('error', 'El QR aún no está disponible.');
        }

        if ($qr->status === QrPlate::STATUS_REGISTERED) {
            $qrOwner = $qr->ownerRegistration;

            if (!$qrOwner || $qrOwner->user_id !== auth()->id()) {
                return back()->with('error', 'Este QR pertenece a otro usuario.');
            }
        }

        DB::transaction(function () use ($qr, $pet) {

            $qr->update([
                'pet_id' => $pet->id,
            ]);

            $qr->addEvent('assigned', now(), [
                'pet_id' => $pet->id,
                'user_id' => auth()->id()
            ]);
        });

        session()->forget('claimed_qr_id');

        return redirect()->route('owner.dashboard')
            ->with('success', 'QR asignado correctamente.');
    }

    // crear mascota + asignar
    public function createAndAssign(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'breed_id' => 'required|exists:breeds,id',
        ]);

        $qr = QrPlate::findOrFail(session('claimed_qr_id'));

        $owner = Owner::where('user_id', auth()->id())->firstOrFail();

        DB::transaction(function () use ($request, $qr, $owner) {

            // crear mascota
            $pet = Pet::create([
                'name' => $request->name,
                'breed_id' => $request->breed_id,
                'owner_id' => $owner->id,
            ]);

            // asignar QR
            $qr->update([
                'pet_id' => $pet->id,
            ]);

            // evento
            $qr->addEvent('assigned', now(), [
                'pet_id' => $pet->id,
                'user_id' => auth()->id()
            ]);
        });

        session()->forget('claimed_qr_id');

        return redirect()->route('owner.dashboard')
            ->with('success', 'Mascota creada y QR asignado.');
    }
}