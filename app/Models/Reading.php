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
        // otros campos si los tienes
    ];

    // Relaciones
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function qrPlate()
    {
        return $this->belongsTo(QRPlate::class, 'QRPlate_id');
    }
}