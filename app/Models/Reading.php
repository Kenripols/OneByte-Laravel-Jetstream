<?php

namespace App\Models;
use App\Models\PetStateHistory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    use HasFactory;

    protected $casts = ['metadata' => 'array',];
    protected $fillable = ['qr_plate_id','user_id','cell_phone','ip','user_agent','lat','lng','metadata',];
    
// La lectura realizada es de una placa QR y por asociacion de una mascota
    public function qrPlate()
    {
        return $this->belongsTo(QrPlate::class, 'qr_plate_id');
    }
    public function pet()
    {
           return $this->qrPlate?->pet; // como ahora es reading->qr->pet, hice el helper para traer la mascota
    }
    public function messages()
    {
        return $this->hasMany(\App\Models\QrMessage::class);
    }
}