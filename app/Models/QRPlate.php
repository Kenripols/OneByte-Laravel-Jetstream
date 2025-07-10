<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Solo si querés soportar borrado lógico
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QRPlate extends Model
{
    use HasFactory;
    use SoftDeletes; // ← Activa si querés borrado lógico en QRPlates

<<<<<<< Updated upstream
    public function pet()
=======
    protected $fillable = [
        'code',
        'pet_id',
        'iDate',
        'eDate',
    ];

    public function pet(): BelongsTo
>>>>>>> Stashed changes
    {
        return $this->belongsTo(Pet::class);
    }
}
