<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TestResult extends Model
{
    use HasFactory;

    protected $table = 'test_results';

    protected $fillable = [
        'test_id',
        'application_id',
        'score',
        'total_questions',
        'correct_answers',
        'wrong_answers',
        'passed',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'float',
            'total_questions' => 'integer',
            'correct_answers' => 'integer',
            'wrong_answers' => 'integer',
            'passed' => 'boolean',
        ];
    }

    // relasi one to one, satu hasil ujian hanya untuk satu sesi tes
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    // relasi one to one, satu hasil ujian hanya untuk satu lamaran
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    // helper untuk menghitung persentase jawaban benar
    protected function percentage(): Attribute
    {
        return Attribute::get(function () {
            if ($this->total_questions == 0) {
                return 0;
            }
            return round(($this->correct_answers / $this->total_questions) * 100, 2);
        });
    }

    // helper untuk mendapatkan grade/nilai huruf berdasarkan persentase
    protected function grade(): Attribute
    {
        return Attribute::get(function () {
            $percentage = $this->percentage;

            if ($percentage >= 85) return 'A';
            if ($percentage >= 70) return 'B';
            if ($percentage >= 60) return 'C';
            if ($percentage >= 50) return 'D';
            return 'E';
        });
    }
}
