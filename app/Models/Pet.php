<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles; //lo sacaria

class Pet extends Model
{
    use HasFactory, HasRoles, SoftDeletes;

    protected $fillable = [
        'photo', 'name', 'bDate', 'breed_id', 'owner_id'
    ];

    protected $casts = [
        'bDate' => 'date',
    ];

    //Especifico la relacion de una mascota pertenece a una raza
    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class, 'breed_id', 'id');
    }

    // Especifico la relacion de una mascota pertenece a un owner
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'user_id');
    }

    // Especifico la relacion de una mascota tiene muchas placas QR
    public function q_r_plates(): HasMany
    {
        return $this->hasMany(QRPlate::class, 'pet_id');
    }
}
//revisar el has roles que me parece que no va