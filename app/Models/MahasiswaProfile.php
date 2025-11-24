<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaProfile extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa_profiles';

    // bisa diisi
    protected $fillable = 
    [
        'user_id',
        'nim',
        'program_studi',
        'angkatan',
        'ipk',
        'semester',
        'foto',
        'cv_path',
        'transkrip_path'
    ];

    // casting
    protected $casts = 
    [
        'ipk' => 'float',
        'semester' => 'integer',
        'angkatan' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // relasi satu profile hanya dimiliki satu user
    public function user() {
        return $this->belongsTo(User::class);
    }

    // helper untuk mendapatkan url foto lengkap
    public function getFotoUrlAttribute() 
    {
        return $this->foto ? asset('storage/' .$this->foto) : asset('images/default-avatar-png');
    }

    // helper untuk mendapatkan url foto lengkap
    public function getCvUrlAttribute() 
    {
        return $this->cv_path ? asset('storage/' .$this->cv_path) : null;
    }

    // helper untuk mendapatkan url foto lengkap
    public function getTranskripUrlAttribute() 
    {
        return $this->transkrip_path ? asset('storage/' . $this->transkrip_path) : null;
    }

}
