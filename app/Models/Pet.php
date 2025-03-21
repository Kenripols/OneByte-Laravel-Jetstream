<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo', 'name', 'bDate', 'breed_id', 'owner_id'
    ];

    public function Breeds()
    {
        return $this->hasOne(Breed::class);
        
    }


}