<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nim',
        'phone',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // satu user cuma satu profil mhs
    public function mahasiswaProfile(): HasOne
    {
        return $this->hasOne(MahasiswaProfile::class);
    }

    // satu mhs banyak lamaran
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'mahasiswa_id');
    }

    // satu recruiter banyak lowongan
    public function lowongans(): HasMany
    {
        return $this->hasMany(Lowongan::class, 'recruiter_id');
    }

    // buat recruiter, tp nyusul aja
    // filter user mahasiswa
    public function scopeMahasiswa($query)
    {
        return $query->where('role', 'mahasiswa');
    }

    // filter user recruiter
    public function scopeRecruiter($query)
    {
        return $query->where('role', 'recruiter');
    }

    // filter user aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
