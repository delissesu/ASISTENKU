<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class MahasiswaProfile extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa_profiles';

    protected $fillable = [
        'user_id',
        'nim',
        'program_studi',
        'angkatan',
        'ipk',
        'semester',
        'phone',
        'foto',
        'cv_path',
        'transkrip_path'
    ];

    protected function casts(): array
    {
        return [
            'ipk' => 'float',
            'semester' => 'integer',
            'angkatan' => 'integer',
        ];
    }

    // relasi one to one, satu profil hanya dimiliki oleh satu user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    // helper untuk mendapatkan url foto profil
    protected function fotoUrl(): Attribute
    {
        return Attribute::get(
            fn () => $this->foto 
                ? asset('storage/' . $this->foto) 
                : asset('images/default-avatar.png')
        );
    }

    // helper untuk mendapatkan url cv
    protected function cvUrl(): Attribute
    {
        return Attribute::get(
            fn () => $this->cv_path 
                ? asset('storage/' . $this->cv_path) 
                : null
        );
    }

    // helper untuk mendapatkan url transkrip
    protected function transkripUrl(): Attribute
    {
        return Attribute::get(
            fn () => $this->transkrip_path 
                ? asset('storage/' . $this->transkrip_path) 
                : null
        );
    }
}