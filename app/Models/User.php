<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\QrPlate;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, HasRoles, SoftDeletes;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'claimed_qr_id', // Agrego el campo para asignar QR pendiente
    ];

    /**
     * Los atributos que deben ocultarse para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Los atributos que deben convertirse a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Los acesores que se añadirán a la representación en forma de array del modelo.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Los atributos que deben tratarse como fechas.
     * Incluyendo `deleted_at` para eliminaciones lógicas.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'email_verified_at',
    ];

    // Especifico la relacion de un usuario a un owner
    public function owner()
    {
        return $this->hasOne(Owner::class, 'user_id', 'id');
    }
    public function qrPending()
    {
        return $this->belongsTo(QrPlate::class, 'claimed_qr_id');
    }
}
