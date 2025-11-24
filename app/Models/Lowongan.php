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

    // relasi many to one, banyak lowongan bisa dimiliki satu divisi
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    // relasi many to one, banyak lowongan bisa dibuat oleh satu recruiter
    public function recruiter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    // relasi one to many, satu lowongan bisa punya banyak lamaran
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    // scoping untuk memfilter lowongan yang sedang dibuka
    public function scopeOpen($query)
    {
        return $query->where('status', 'open')
                     ->where('open_date', '<=', now())
                     ->where('close_date', '>=', now());
    }

    // scoping untuk memfilter lowongan berdasarkan status
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // helper untuk cek apakah lowongan sedang dibuka
    public function isOpen(): bool
    {
        return $this->status === 'open'
            && $this->open_date <= now()
            && $this->close_date >= now();
    }

    // helper untuk menghitung sisa kuota lowongan
    protected function remainingQuota(): Attribute
    {
        return Attribute::get(function () {
            $accepted = $this->applications()->where('status', 'accepted')->count();
            return $this->quota - $accepted;
        });
    }
}
