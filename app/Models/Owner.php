<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;  // <-- Importa SoftDeletes
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Owner extends Model
{
    use HasFactory, SoftDeletes;  // <-- Usa SoftDeletes aquí

    protected $table = 'owners';

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
<<<<<<< Updated upstream
        'user_id', 'docType', 'docNum', 'fName1', 'fName2', 'sName1', 'sName2'
                ];
=======
        'doctype', 'docnum', 'fname', 'fname2', 'sname1', 'sname2', 'user_id'
    ];

    // Para que Laravel maneje correctamente la fecha del borrado lógico
    protected $dates = ['deleted_at'];
>>>>>>> Stashed changes

    public function pets()
    {
        return $this->hasMany(Pet::class, 'owner_id', 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

