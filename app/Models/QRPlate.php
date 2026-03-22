<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QRPlate extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'qr_plates';
    protected $fillable = [
        'code', 'pet_id', 'iDate', 'eDate','batch_id','generated_at','downloaded_at',
    ];
// Especifico que una placa QR pertenece a una mascota
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }
}
