<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetHistory extends Model
{
    protected $table = 'pet_status_histories';

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