<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\QRPlate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;
use ZipArchive;
class QRPlateController extends Controller
{
    /* listado con paginate*/ 
    public function index()
<<<<<<< Updated upstream
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
=======
    {   
        $QRPlates = QRPlate::paginate(10); 
        return view('admin.qrplates.index', compact('QRPlates'));
    }
///////////////////////////////////////////////////////////////////
    /* Generar QR (este genera u descarga, despues va el posta porque son procesos separados) /*
    public function generate(Request $request)
    {
        $amount = $request->amount ?? 10; //cantidad de qr, si no elegis te pone 10
        $renderer = new ImageRenderer(
            new RendererStyle(400), //400PX
            new SvgImageBackEnd() //formato svg, con png funciona mas rapido pero se rompe en la resolucion
        );
        $writer = new Writer($renderer);
        $files = [];
        for ($i = 0; $i < $amount; $i++) {
            $code = Str::upper(Str::random(8)); //el code es un random mayuscula de 8 (hay que mejorarlo para que no cree duplicados aunque es casi imposible
            QRPlate::create([
                'code' => $code,
                'iDate' => now()
            ]);
            $url = url('/p/'.$code); //la url de la pagina y el randomio
            $filePath = public_path("qrcodes/$code.svg"); //guardo en la carpeta QR
            $writer->writeFile($url, $filePath); //esto genera el codigo qr 
            $files[] = $filePath; //agrega al array
        }

        $date = now()->format('Y-m-d');
        $zipName = "qr_batch_{$date}_{$amount}.zip"; //hace un archivo que se llama qr_batch y pone fecha y cantidad (hay que agregar el lote cuando este en la BD)
        $zipPath = public_path("qrcodes/$zipName");
        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($files as $file) {//comprime todo lo que hay en el array 
                $zip->addFile($file, basename($file)); 
            }
            $zip->close();
        }
        return response()->download($zipPath)->deleteFileAfterSend(true);//despues de descargar el zip lo borra de local, como guardo el nro de lote puedo descargar una copia entera
    }*/
////////////////////////////////////////////////////////////////
/* esto esta mal porque le pone el ID de batch, cuando lo genera, el numero de lote es al descargar, la proxima te juro que esta bien
public function generate(Request $request)
{
    $batchId = (QrPlate::max('batch_id') ?? 0) + 1;

    $qrs = QrPlate::whereNull('batch_id')
        ->take($request->amount)
        ->get();

    foreach ($qrs as $qr) {
        $qr->update([
            'batch_id' => $batchId,
            'downloaded_at' => now(),
        ]);
>>>>>>> Stashed changes
    }

    return back()->with('success', 'Batch generado');
}
*/
////////////////////////////////////////////////////////////////
public function generate(Request $request)
{
    for ($i = 0; $i < $request->amount; $i++) {
        QrPlate::create([
            'code' => Str::uuid(),
            'batch_id' => null, // 🔥 clave
        ]);
    }

    return back()->with('success', 'QR generados');
}
////////////////////////////////////////////////////////////////
public function download(Request $request)
{
    $amount = $request->amount ?? 10;

    $available = QrPlate::whereNull('batch_id')->count();

    if ($available < $amount) {
        return back()->with('error', "Solo hay $available QR disponibles");
    }

    $batchId = (QrPlate::max('batch_id') ?? 0) + 1;

    $qrs = QrPlate::whereNull('batch_id')
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
    public function create()
    {
<<<<<<< Updated upstream
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
    public function store(Request $request)
=======
        return redirect()->route('admin.qrplates.index')
            ->with('error', 'No tienes permiso para crear placas QR.');
    }
///////////////////////////////////////////////////////////////
    public function store(StoreQRPlateRequest $request)
>>>>>>> Stashed changes
    {
        //
    }

    public function show(QRPlate $qRPlate) {}

    public function edit(QRPlate $qRPlate) {} //se le cambia el estado, 

    public function update(Request $request, QRPlate $qRPlate) {} 

    public function destroy(QRPlate $qRPlate) {} //no destruir si lo usa un perro, manejar borrado logico comoen usuario

//pensar funciones de lote, capaz crear una vista "lote" para no hacerle procesar
}