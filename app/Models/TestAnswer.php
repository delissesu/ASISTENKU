<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestAnswer extends Model
{
    use HasFactory;

    protected $table = 'test_answers';

    protected $fillable = [
        'test_id',
        'question_id',
        'answer',
        'is_correct',
    ];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
        ];
    }

    // banyak jawaban di satu tes
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    // banyak jawaban buat satu soal
    public function question(): BelongsTo
    {
        return $this->belongsTo(QuestionBank::class, 'question_id');
    }
}
