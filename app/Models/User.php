<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',

        // mahasiswa atau recruiter
        'role',

        // hanya untuk mahasiswa
        'nim',
        
        'phone',
        'is_active',
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

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // relasi one to one ke mahasiswa profile
    public function mahasiswaProfile() {
        return $this->hasOne(MahasiswaProfile::class);
    }

    // relasi one to many ke lowongan
    public function applications() {
        return $this->hasMany(Application::class, 'mahasiswa_id');
    }

    // relasi one to many as recruiter, bisa buat banyak lowongan
    public function lowongans()
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

    // scoping untuk filter user yang aktif saja
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
