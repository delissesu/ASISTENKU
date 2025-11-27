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

    // banyak lamaran buat satu lowongan
    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(Lowongan::class);
    }

    // banyak lamaran dari satu mahasiswa
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    // satu lamaran cuma satu ujian
    public function test(): HasOne
    {
        return $this->hasOne(Test::class);
    }

    // filter lamaran pake status
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // filter yang masih pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // filter yang udah diverifikasi
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }
}
