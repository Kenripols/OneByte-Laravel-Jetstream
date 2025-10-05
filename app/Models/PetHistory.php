<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetHistory extends Model
{
    use HasFactory;
    protected $table = 'pet_state_history';

    protected $fillable = [
        'pet_id',
        'state',
        'beginDate',
        'endDate',
    ];

    // Relación con Pet
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}