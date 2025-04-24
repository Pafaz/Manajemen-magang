<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guard_name = 'api';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'telepon',
        'password',
        'google_id',
        'avatar',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function perusahaan()
    {
        return $this->hasOne(Perusahaan::class, 'id_user', 'id');
    }
    
    public function peserta()
    {
        return $this->hasOne(Peserta::class, 'id_user', 'id');
    }

    public function admin_cabang()
    {
        return $this->hasOne(Admin_cabang::class, 'id_user', 'id');
    }

    public function mentor()
    {
        return $this->hasOne(Mentor::class, 'id_user', 'id');
    }
}
