<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Test extends Model
{
    use HasFactory;

    protected $table = 'tests';

    protected $fillable = [
        'application_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'duration_minutes' => 'integer',
        ];
    }

    // relasi one to one, satu ujian hanya untuk satu lamaran
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    // relasi one to many, satu sesi tes bisa punya banyak jawaban
    public function testAnswers(): HasMany
    {
        return $this->hasMany(TestAnswer::class);
    }

    // relasi one to one, satu sesi tes hanya punya satu hasil
    public function testResult(): HasOne
    {
        return $this->hasOne(TestResult::class);
    }

    // scoping untuk memfilter tes yang sedang berlangsung
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    // scoping untuk memfilter tes yang sudah selesai
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }


    // helper untuk cek apakah waktu tes sudah habis
    public function isExpired(): bool
    {
        return now()->greaterThan($this->end_time);
    }

    // helper untuk menghitung sisa waktu tes dalam menit
    protected function remainingTime(): Attribute
    {
        return Attribute::get(function () {
            if ($this->status !== 'in_progress') {
                return 0;
            }
            $remaining = now()->diffInMinutes($this->end_time, false);
            return max(0, $remaining);
        });
    }
}
