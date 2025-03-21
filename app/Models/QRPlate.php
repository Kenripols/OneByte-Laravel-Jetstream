<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRPlate extends Model
{
    use HasFactory;

    public function pets()
    {
        return $this->belongsTo(Pet::class);
    }
}