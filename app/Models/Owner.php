<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Owner extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id'; // Defino la clave primaria
    
    /*
    Asignar que tabla va a manejar
    */
    protected $table ='owners';
//Convertir Mayusculas a minusculas del campo nombre1 y Convertir la primer letra a Mayuscula
    protected function nombre1(): Attribute {
        return Attribute::make(
            set: function($value){
                return strtolower($value);           
            },
            get: function($value) {
                return ucfirst($value);
            }
        );

        
        
    }
    //Asignación masiva
    protected $fillable = [
        'docType', 'docNum', 'fname1', 'fname2', 'sname1', 'sname2'
                ];

                //Especifico la relacion de uno a N
    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    
}
