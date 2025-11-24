<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestAnswer extends Model
{
    use HasFactory;

    protected $table = 'test_answers';

    protected $fillable = 
    [
        'test_id',
        'question_id',
        'answer',
        'is_correct',
    ];

    protected $casts = 
    [
        'is_correct' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // relasi many to one, banyak jawaban ujian dalam satu kali tes
    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    // relasi many to one, banyak jawaban tes dalam satu pertanyaan
    public function question()
    {
        return $this->belongsTo(QuestionBank::class, 'question_id');
    }

}
