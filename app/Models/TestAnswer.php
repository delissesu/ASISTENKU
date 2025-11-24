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

    // relasi many to one, banyak jawaban dalam satu sesi tes
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    // relasi many to one, banyak jawaban bisa untuk satu soal
    public function question(): BelongsTo
    {
        return $this->belongsTo(QuestionBank::class, 'question_id');
    }
}
