<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrMessage extends Model
{
    protected $guarded = [];

    public function reading()
    {
        return $this->belongsTo(\App\Models\Reading::class);
    }
}
