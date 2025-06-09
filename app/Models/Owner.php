<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Owner extends Model
{
    use HasFactory;

    
    /*
    Asignar que tabla va a manejar
    */
    protected $table ='owners';
    //Asignación masiva
    protected $fillable = [
        'docType', 'docNum', 'fname1', 'fname2', 'sname1', 'sname2'
                ];

    //Especifico la relacion de uno a N con mascotas
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
