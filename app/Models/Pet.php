<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne; //16-12-25 Agregué HasOne

class Pet extends Model
{
    use HasFactory, SoftDeletes; //16-12-25 En esta linea saqué HasRoles

    protected $fillable = [
        'photo', 'name', 'bDate', 'breed_id', 'owner_id'
    ];

    protected $casts = [
        'bDate' => 'date',
    ];

    //Especifico la relacion de una mascota pertenece a una raza
    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }

    // Especifico la relacion de una mascota pertenece a un owner
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    // Especifico la relacion de una mascota tiene muchas placas QR
    public function qrPlates(): HasMany
    {
        return $this->hasMany(QrPlate::class);
    }

    // Especifico la relacion de una mascota tiene muchos historiales de estado
    public function petStateHistories(): HasMany
    {
        return $this->hasMany(PetHistory::class); 
    }

    // 16-12-25 Especifico la relacion de una mascota en un único historial, el mas reciente
    public function currentState(): HasOne
    {
        return $this->hasOne(PetHistory::class)
                ->whereNull('endDate')
                ->latestOfMany('beginDate');
    }

}
