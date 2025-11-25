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
        'score',
        'passed',
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

    // Method to calculate and save score after test completion
    public function calculateScore(): void
    {
        $answers = $this->testAnswers()->with('question')->get();
        
        if ($answers->isEmpty()) {
            $this->score = 0;
            $this->passed = false;
            $this->save();
            return;
        }
        
        $totalPoints = $answers->sum(fn($a) => $a->question->points);
        $correctPoints = $answers->where('is_correct', true)
                                 ->sum(fn($a) => $a->question->points);
        
        $this->score = $totalPoints > 0 ? round(($correctPoints / $totalPoints) * 100, 2) : 0;
        $this->passed = $this->score >= 70; // Passing threshold 70%
        $this->save();
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

    // Accessor attributes untuk kompatibilitas dengan struktur lama
    protected function totalQuestions(): Attribute
    {
        return Attribute::get(fn () => $this->testAnswers()->count());
    }

    protected function correctAnswers(): Attribute
    {
        return Attribute::get(fn () => $this->testAnswers()->where('is_correct', true)->count());
    }

    protected function wrongAnswers(): Attribute
    {
        return Attribute::get(fn () => $this->testAnswers()->where('is_correct', false)->count());
    }
}
