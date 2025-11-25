<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $fillable = [
        'lowongan_id',
        'mahasiswa_id',
        'portofolio_url',
        'motivation_letter',
        'admin_notes',
        'status',
        'applied_at'
    ];

    protected function casts(): array
    {
        return [
            'applied_at' => 'datetime',
        ];
    }

    // relasi many to one, banyak lamaran bisa untuk satu lowongan
    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(Lowongan::class);
    }

    // relasi many to one, banyak lamaran bisa dibuat oleh satu mahasiswa
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    // relasi one to one, satu lamaran hanya punya satu sesi ujian
    public function test(): HasOne
    {
        return $this->hasOne(Test::class);
    }

    // scoping untuk memfilter lamaran berdasarkan status
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // scoping untuk memfilter lamaran yang masih pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // scoping untuk memfilter lamaran yang sudah diverifikasi
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }
}
