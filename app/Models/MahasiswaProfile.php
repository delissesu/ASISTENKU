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
        $ipk => 'float',
        $semester => 'integer',
        $created_at => 'datetime',
        $updated_at => 'datetime'
    ];

    // relasi
    public function user() {
        return $this->belongsTo(User::class);
    }

}
