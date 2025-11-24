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

    // relasi one to one, satu user hanya punya satu profil mahasiswa
    public function mahasiswaProfile(): HasOne
    {
        return $this->hasOne(MahasiswaProfile::class);
    }

    // relasi one to many, satu mahasiswa bisa punya banyak lamaran
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'mahasiswa_id');
    }

    // relasi one to many, satu recruiter bisa membuat banyak lowongan
    public function lowongans(): HasMany
    {
        return $this->hasMany(Lowongan::class, 'recruiter_id');
    }

    // scoping untuk memfilter user dengan role mahasiswa
    public function scopeMahasiswa($query)
    {
        return $query->where('role', 'mahasiswa');
    }

    // scoping untuk memfilter user dengan role recruiter
    public function scopeRecruiter($query)
    {
        return $query->where('role', 'recruiter');
    }

    // scoping untuk memfilter user yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
