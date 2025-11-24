<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    use HasFactory;

    protected $table = 'divisions';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'requirements',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // relasi one to many, satu divisi bisa punya banyak lowongan
    public function lowongans(): HasMany
    {
        return $this->hasMany(Lowongan::class);
    }

    // relasi one to many, satu divisi bisa punya banyak pertanyaan atau soal ujian
    public function questionBanks(): HasMany
    {
        return $this->hasMany(QuestionBank::class);
    }

    // scoping untuk memfilter divisi yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
