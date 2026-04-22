<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\QREventType;
use Illuminate\Support\Facades\DB;

class QrPlate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'qr_plates';

    // Estados
        const STATUS_GENERATED  = 1;
        const STATUS_DOWNLOADED = 2;
        const STATUS_CLAIMED    = 3; 
        const STATUS_REGISTERED = 4;
        const STATUS_ASSIGNED   = 5;
        const STATUS_EXPIRED    = 6;
        const STATUS_REPLACED   = 7;

    protected $fillable = [
        'code',
        'pet_id',
        'batch_id',
        'status',
        'owner_user_id'
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    // Relaciones

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(QrEvent::class, 'qr_plate_id');
    }

    public function ownerRegistration()
    {
        return $this->hasOne(Owner::class, 'registration_qr_id');
    }

    public function readings()
    {
        return $this->hasMany(Reading::class);
    }

    // Lógica

    public function isUsable(): bool
    {
        return in_array($this->status, [
            self::STATUS_DOWNLOADED,
            self::STATUS_REGISTERED
        ]);
    }

    public function isAssigned(): bool
    {
        return $this->pet_id !== null;
    }

    // Labels

    public function getStatusLabelAttribute()
    {
        return self::statuses()[$this->status] ?? 'Desconocido';
    }

    public static function statuses()
    {
        return [
            self::STATUS_GENERATED  => 'Generado',
            self::STATUS_DOWNLOADED => 'Descargado',
            self::STATUS_REGISTERED => 'Registrado',
            self::STATUS_ASSIGNED   => 'Asignado',
            self::STATUS_EXPIRED    => 'Caducado',
            self::STATUS_REPLACED   => 'Sustituido',
        ];
    }

    
//add event para ponerle estados con fecha
  public function addEvent(string|QREventType $type, $date = null, array $metadata = [])
        {
            if ($type instanceof QREventType) {
                $type = $type->value;
            }

            $event = $this->events()->create([
                'type' => $type,
                'created_at' => $date ?? now(),
                'metadata' => $metadata ?: null,
            ]);

            $newStatus = $this->mapEventToStatus($type);

            if ($newStatus !== null) {
                $this->update(['status' => $newStatus]);
            }

            return $event;
        }
    public function canBeUsedBy($user): bool
    {
        // ya asignado (doble seguridad)
        if ($this->pet_id !== null) {
            return false;
        }
        // no disponible
        if ($this->status === self::STATUS_GENERATED) {
            return false;
        }
        // estados inválidos
        if (in_array($this->status, [
            self::STATUS_ASSIGNED,
            self::STATUS_EXPIRED,
            self::STATUS_REPLACED
        ])) {
            return false;
        }
        // registrado → validar dueño
        if ($this->status === self::STATUS_REGISTERED) {
            $owner = $this->ownerRegistration;
            if (!$owner || $owner->user_id !== $user->id) {
                return false;
            }
        }
        return true;
    }
    public function getEventDate($type)
    {
        return $this->events()
            ->where('type', $type)
            ->latest()
            ->value('created_at');
    }
    private function mapEventToStatus(string $type): ?int
    {
        return match($type) {
            'generated'  => self::STATUS_GENERATED,
            'downloaded' => self::STATUS_DOWNLOADED,
            'claimed'    => self::STATUS_CLAIMED,  
            'registered' => self::STATUS_REGISTERED,
            'assigned'   => self::STATUS_ASSIGNED,
            'expired'    => self::STATUS_EXPIRED,
            'replaced'   => self::STATUS_REPLACED,
            'forgotten'  => self::STATUS_DOWNLOADED, //cuando dejo de tenerlo en pendiente lo dejo disponible como recien descargado
            default      => null
        };
    }
    public function forget($userId = null) //le sacas el qr pendiente al tipo
    {
        return DB::transaction(function () use ($userId) {

            $this->addEvent('forgotten', now(), [
                'user_id' => $userId
            ]);

            return $this;
        });
    }
    public function lastReading(){
        return $this->hasOne(Reading::class)->latestOfMany();
    }
    public function readingsCount(){
        return $this->readings()->count();
    }
    
}