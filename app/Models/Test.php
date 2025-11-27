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

    // satu ujian buat satu lamaran
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    // satu tes banyak jawaban
    public function testAnswers(): HasMany
    {
        return $this->hasMany(TestAnswer::class);
    }

    // itung nilai abis tes kelar
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

    // filter tes yang lagi jalan
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    // filter tes yang udah kelar
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }


    // cek waktu abis ga
    public function isExpired(): bool
    {
        return now()->greaterThan($this->end_time);
    }

    // itung sisa waktu (menit)
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

    // biar support struktur lama
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
