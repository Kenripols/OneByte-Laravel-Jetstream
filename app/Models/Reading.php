<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'QRPlate_id',
    ];

    
// La lectura realizada es de una placa QR y por asociacion de una mascota
    public function qrPlate()
    {
        return $this->belongsTo(QRPlate::class, 'QRPlate_id');
    }
}