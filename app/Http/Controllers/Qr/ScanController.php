<?php 

namespace App\Http\Controllers\Qr;

use App\Http\Controllers\Controller;
use App\Models\QrPlate;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    public function handle($code)
{
    $qr = QrPlate::where('code', $code)->first();

    if (!$qr) {
        return view('qr.unavailable');
    }

    if (!Auth::check()) {
    return view('qr.public', compact('qr'));
    }

    if (!$qr->canBeUsedBy(Auth::user())) {
        return view('qr.unavailable');
    }

    return redirect()->route('owner.qr.resolve', $qr->code);
}

    public function resolve($code)
    {
        $qr = QrPlate::where('code', $code)->firstOrFail();

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!$qr->canBeUsedBy(Auth::user())) {
            return view('qr.unavailable');
        }

        return view('qr.choose_action', compact('qr'));
    }
}