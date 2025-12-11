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

    // user mahasiswa cuma punya 1 profil
    public function mahasiswaProfile(): HasOne
    {
        return $this->hasOne(MahasiswaProfile::class);
    }

    // mahasiswa bisa ngelamar banyak
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'mahasiswa_id');
    }

    // recruiter bisa buka banyak lowongan
    public function lowongans(): HasMany
    {
        return $this->hasMany(Lowongan::class, 'recruiter_id');
    }

    // ini buat recruiter nanti aja
    // cari user yg mahasiswa doang
    public function scopeMahasiswa($query)
    {
        return $query->where('role', 'mahasiswa');
    }

    // cari user recruiter doang
    public function scopeRecruiter($query)
    {
        return $query->where('role', 'recruiter');
    }

    // cari user yg aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
