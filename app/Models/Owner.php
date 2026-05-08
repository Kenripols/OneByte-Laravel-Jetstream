<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Owner extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'owners';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id', 'docType', 'docNum', 'fName1', 'fName2', 'sName1', 'sName2','registration_qr_id', 'phone'
                ];

                // Para que Laravel maneje correctamente la fecha del borrado lógico
    //protected $dates = ['deleted_at'];  como pusimos softdelete en el migrate esto no se

    //Especifico la relacion uno a N con mascotas
    public function pets()
    {
        return $this->hasMany(Pet::class, 'owner_id', 'user_id');
    }

    //Especifico la relacion de un usuario a un owner
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    //el qr con el usaurio
    public function registrationQr()
    {
        return $this->belongsTo(QrPlate::class, 'registration_qr_id');
    }
    public function getDocTypeLabelAttribute()
    {
        return [
            1 => 'Cédula',
            2 => 'Pasaporte',
            3 => 'DNI Extranjero'
        ][$this->docType] ?? 'Desconocido';
    }
    
}

