<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrMessage extends Model
{
    public function reading()
    {
        return $this->belongsTo(\App\Models\Reading::class);
    }
}
