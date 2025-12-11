<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongans';

    protected $fillable = [
        'division_id',
        'recruiter_id',
        'title',
        'location',
        'description',
        'quota',
        'min_ipk',
        'min_semester',
        'open_date',
        'close_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'quota' => 'integer',
            'min_ipk' => 'float',
            'min_semester' => 'integer',
            'open_date' => 'date',
            'close_date' => 'date',
        ];
    }

    // dari satu divisi
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    // punya satu recruiter
    public function recruiter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    // yg ngelamar banyak
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    // cari lowongan yg lagi buka
    public function scopeOpen($query) // filter langsung di db
    {
        return $query->where('status', 'open')
                     ->where('open_date', '<=', now())
                     ->where('close_date', '>=', now());
    }

    // filter status (nyusul)
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // cek masih buka ga
    public function isOpen(): bool
    {
        return $this->status === 'open'
            && $this->open_date <= now()
            && $this->close_date >= now();
    }

    // cek bentar lg tutup
    public function isClosingSoon(): bool
    {
        return $this->isOpen() && $this->close_date->diffInDays(now()) <= 7;
    }

    // itung sisa kuota brp
    protected function remainingQuota(): Attribute
    {
        return Attribute::get(function () {
            $accepted = $this->applications()->where('status', 'accepted')->count();
            return $this->quota - $accepted;
        });
    }
}
