<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    use HasFactory;

    protected $casts = [
    'bDate' => 'date',
];

    protected $fillable = [
        'photo', 'name', 'bDate', 'breed_id', 'owner_id'
    ];

//Especifico la relacion de una mascota pertenece a una raza
    public function breed()
{
    return $this->belongsTo(Breed::class, 'breed_id', 'id');
}
//Especifico la relacion de uno a uno
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'user_id');
    }
    
   


}