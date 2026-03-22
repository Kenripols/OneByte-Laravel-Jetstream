<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQRPlateRequest;
use App\Models\QRPlate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;
use ZipArchive;

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
    public function show(QRPlate $qrPlate)
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



public function generate(Request $request)
{
    $amount = (int) ($request->amount ?? 0);

    if ($amount <= 0) {
        return back()->with('error', 'Cantidad inválida.');
    }

    for ($i = 0; $i < $amount; $i++) {
        QRPlate::create([
            'code' => (string) Str::uuid(),
            'batch_id' => null,
        ]);
    }

    return back()->with('success', "Se generaron {$amount} QR correctamente.");
}

public function download(Request $request)
{
    $amount = $request->amount ?? 10;

    $available = QRPlate::whereNull('batch_id')->count();

    if ($available < $amount) {
        return back()->with('error', "Solo hay $available QR disponibles");
    }

    $batchId = (QRPlate::max('batch_id') ?? 0) + 1;

    $qrs = QRPlate::whereNull('batch_id')
        ->orderBy('id')
        ->take($amount)
        ->get();

    $renderer = new ImageRenderer(
        new RendererStyle(400),
        new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
    );

    $writer = new Writer($renderer);

    $files = [];

    foreach ($qrs as $qr) {
        $url = url('/p/' . $qr->code);

        $filePath = public_path("temp_qr/{$qr->code}.svg");

        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        $writer->writeFile($url, $filePath);

        $files[] = $filePath;

        // 🔥 asigna batch acá
        $qr->update([
            'batch_id' => $batchId,
            'downloaded_at' => now(),
        ]);
    }

    $zipName = "lote_{$batchId}.zip";
    $zipPath = public_path("temp_qr/$zipName");

    $zip = new ZipArchive;

    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();
    }

    // borrar imágenes temporales
    foreach ($files as $file) {
        unlink($file);
    }

    return response()->download($zipPath)->deleteFileAfterSend(true);
}
//////////////////////////////////////
    /*  Bloquear creación manual */
public function getDisponiblesCountProperty(){
            return QrPlate::whereNull('batch_id')->count();
    }
}
