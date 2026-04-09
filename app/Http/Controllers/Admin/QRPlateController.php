<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QRPlate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;
use ZipArchive;

class QRPlateController extends Controller
{
    //Listado
    public function index()
    {
        $QRPlates = QRPlate::paginate(10);
        return view('admin.qrplates.index', compact('QRPlates'));
    }

    
    //Bloquear creacion manual
    public function create()
    {
        return redirect()->route('admin.qrplates.index')
            ->with('error', 'No tienes permiso para crear placas QR.');
    }

    public function store()
    {
        return redirect()->route('admin.qrplates.index')
            ->with('error', 'No tienes permiso para crear placas QR.');
    }

    //Generar QRs en masa
    public function generate(Request $request)
    {
        $amount = (int) ($request->amount ?? 0);

        if ($amount <= 0) {
            return back()->with('error', 'Cantidad inválida.');
        }

        for ($i = 0; $i < $amount; $i++) {
            $qr = QRPlate::create([
                'code' => (string) Str::uuid(),
                'batch_id' => null,
            ]);

$qr->addEvent('generated');
        }

        return back()->with('success', "Se generaron {$amount} QR correctamente.");
    }

    
    //Descargar lote de QRs
    public function download(Request $request)
    {
        $amount = (int) ($request->amount ?? 10);

        $available = QRPlate::where('status', QRPlate::STATUS_GENERATED)->count();

        if ($available < $amount) {
            return back()->with('error', "Solo hay $available QR disponibles");
        }

        // busca el ultimo batch y le suma 1 para el nuevo.
        $batchId = (QRPlate::max('batch_id') ?? 0) + 1;

        $files = [];

        DB::transaction(function () use ($amount, $batchId, &$files) {

            $qrs = QRPlate::where('status', QRPlate::STATUS_GENERATED)
                ->lockForUpdate()
                ->orderBy('id')
                ->limit($amount)
                ->get();

            $renderer = new ImageRenderer(
                new RendererStyle(400),
                new SvgImageBackEnd()
            );

            $writer = new Writer($renderer);

            foreach ($qrs as $qr) {

                $url = url('/qr/' . $qr->code);
                $filePath = public_path("temp_qr/{$qr->code}.svg");

                if (!file_exists(dirname($filePath))) {
                    mkdir(dirname($filePath), 0777, true);
                }

                $writer->writeFile($url, $filePath);
                $files[] = $filePath;

               $qr->update([
                    'batch_id' => $batchId,
                ]);
                $qr->addEvent('downloaded');
            }
        });

        // crear ZIP
        $zipName = "lote_{$batchId}.zip";
        $zipPath = public_path("temp_qr/$zipName");
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($files as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        }
        // borrar SVG temporales
        foreach ($files as $file) {
            unlink($file);
        }
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
    //Contador de QRs disponibles
    public function getDisponiblesCountProperty()
    {
        return QRPlate::where('status', QRPlate::STATUS_GENERATED)->count();
    }
}