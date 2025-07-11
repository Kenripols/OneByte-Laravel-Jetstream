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
        'user_id', 'docType', 'docNum', 'fName1', 'fName2', 'sName1', 'sName2'
                ];

                // Para que Laravel maneje correctamente la fecha del borrado lógico
    protected $dates = ['deleted_at'];

    //Especifico la relacion uno a N con mascotas
    public function pets()
    {
        return $this->hasMany(Pet::class, 'owner_id', 'user_id');
    }

    //Especifico la relacion de un usuario a un owner
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

