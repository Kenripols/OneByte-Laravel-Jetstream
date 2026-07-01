<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Breed extends Model
{
    use HasFactory;

    protected $fillable = [
        'animalType', 'size', 'breedName'
    ];

    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }
}