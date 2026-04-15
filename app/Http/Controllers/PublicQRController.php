<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\QRPlate;

class PublicQrController extends Controller
{
    public function sendLocation(Request $request, $code)
    {
        // 1) Validación
        $data = $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'message' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048',
        ]);

        // 2) Buscar QR con relaciones
        $qr = QRPlate::with('pet.owner.user')
            ->where('code', $code)
            ->firstOrFail();

        if (!$qr->pet || !$qr->pet->owner || !$qr->pet->owner->user) {
            Log::warning('QR sin dueño', ['code' => $code]);
            return response()->json(['error' => 'QR sin dueño'], 422);
        }

        $owner = $qr->pet->owner->user;

        if (!$owner->email) {
            Log::warning('Owner sin email', ['owner_id' => $owner->id]);
            return response()->json(['error' => 'Dueño sin email'], 422);
        }

        // 3) Guardar foto (opcional)
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('found_reports', 'public');
        }

        // 4) Preparar datos
        $lat = $data['lat'];
        $lng = $data['lng'];
        $msg = $data['message'] ?? 'Sin mensaje';

        // 5) Armar mail
        $body = "Tu mascota fue encontrada\n\n";
        $body .= "Mensaje:\n{$msg}\n\n";
        $body .= "Ubicación:\nhttps://maps.google.com/?q={$lat},{$lng}\n";

        try {
            Mail::raw($body, function ($m) use ($owner, $photoPath) {
                $m->to($owner->email)
                  ->subject('Tu mascota fue encontrada');

                if ($photoPath) {
                    $m->attach(storage_path('app/public/' . $photoPath));
                }
            });

        } catch (\Throwable $e) {
            Log::error('Error enviando mail', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'No se pudo enviar el mail'], 500);
        }

        // 6) Log de éxito
        Log::info('Ubicación enviada', [
            'qr' => $code,
            'owner' => $owner->email,
            'lat' => $lat,
            'lng' => $lng
        ]);

        return response()->json(['ok' => true]);
    }
}