<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',        
        'type',
        'pet_id',
        'image',
        'is_active',
        'publish_at',
        'expires_at',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}