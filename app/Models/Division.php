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

    // satu divisi banyak lowongan
    public function lowongans(): HasMany
    {
        return $this->hasMany(Lowongan::class);
    }

    // satu divisi banyak soal
    public function questionBanks(): HasMany
    {
        return $this->hasMany(QuestionBank::class);
    }

    // filter divisi yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
