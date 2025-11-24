<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $table = 'divisions';

    // pk id default, tp eksplisit aja
    protected $primaryKey = 'id';

    // bisa diisi
    protected $fillable = 
    [
        'name',
        'slug',
        'description',
        'requirements',
        'is_active'
    ];

    // casting
    protected $casts = 
    [
        'is_active' => 'boolean',
        'created_at' => 'datettime',
        'updated_at' => 'datettime',
    ];

    // relasi satu divisi bisa punya banyak lowongan
    public function lowongans() {
        return $this->hasMany(Lowongan::class);
    }

    // relasi satu divisi bisa punya banyak pertanyaan atau soal ujian
    public function questionBanks() {
        return $this->hasMany(QuestionBank::class);
    }

    // scoping untuk memfilter divisi yang aktif
    public function scopeActive($query) 
    {
        return $query->where('is_active', true);
    }
}
