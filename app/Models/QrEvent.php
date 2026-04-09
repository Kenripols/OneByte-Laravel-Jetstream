<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrEvent extends Model
{
    protected $table = 'qr_plate_events';

    protected $fillable = [
        'qr_plate_id',
        'type',
        'metadata',
        'created_at', //  para seeders
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    public $timestamps = true;

    public function qrPlate(): BelongsTo
    {
        return $this->belongsTo(QrPlate::class);
    }

    public function isType(string $type): bool
    {
        return $this->type === $type;
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query)
    {
        return $query->orderByDesc('created_at');
    }
}