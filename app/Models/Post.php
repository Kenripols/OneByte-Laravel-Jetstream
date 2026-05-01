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
// Cast necesario para que al consultar los posts, los campos de fecha se conviertan automáticamente a objetos Carbon y el campo is_active a booleano (Arregla el dashboard del owner)
    protected $casts = [
    'is_active' => 'boolean',
    'publish_at' => 'datetime',
    'expires_at' => 'datetime',
];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}