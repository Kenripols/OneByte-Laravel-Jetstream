<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PetState;

class PetStateHistory extends Model
{
    use HasFactory;
    protected $table = 'pet_state_history';
    protected $casts = [
        'state' => PetState::class,
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    protected $fillable = [
        'pet_id',
        'state',
        'started_at',
        'ended_at',
    ];

    // Relación con Pet
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}