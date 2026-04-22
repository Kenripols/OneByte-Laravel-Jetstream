<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne; //16-12-25 Agregué HasOne
use App\Enums\PetState;

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
    public function breed(): BelongsTo{
        return $this->belongsTo(Breed::class);
    }

    // Especifico la relacion de una mascota pertenece a un owner
    public function owner(): BelongsTo{
        return $this->belongsTo(Owner::class);
    }

    // Especifico la relacion de una mascota tiene muchas placas QR
    public function qrPlates(): HasMany{
        return $this->hasMany(QrPlate::class);
    }

    // Especifico la relacion de una mascota tiene muchos historiales de estado
    public function petStateHistories(): HasMany{
        return $this->hasMany(PetStateHistory::class); 
    }

    // 16-12-25 Especifico la relacion de una mascota en un único historial, el mas reciente
    public function currentStateModel(): HasOne{
        return $this->hasOne(PetStateHistory::class)
            ->whereNull('ended_at') //como es estado no terminó es el actal
            ->latestOfMany('started_at');
    }
    public function getCurrentStateAttribute(): ?PetState{
            return $this->currentStateModel?->state;
        }
    public function hasQR(): bool{
        return $this->qrPlates()->exists();
    }
    public function isExpired(): bool{
        return !$this->hasQR() && $this->created_at < now()->subDays(2);
    }
    public function isPending(): bool{
        return !$this->hasQR() && !$this->isExpired();
    }
    public function isLost(): bool{
        return $this->current_state === PetState::LOST;
    }
    public function isReportable(): bool{
        return $this->isLost();
    }
    public function latestState(){
        return $this->hasOne(PetStateHistory::class)->latestOfMany();
    }
    public function qrPlate(){
        return $this->hasOne(QRPlate::class);
    }
    public function currentState(){
        return $this->hasOne(PetStateHistory::class)->latestOfMany();
    }
}
