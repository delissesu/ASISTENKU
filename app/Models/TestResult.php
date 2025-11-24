<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $table = 'test_results';

    protected $fillable = 
    [
        'test_id',
        'application_id',
        'score',
        'total_questions',
        'correct_answers',
        'wrong_answers',
        'passed',
    ];

    protected $casts = [
        'score' => 'float',
        'total_questions' => 'integer',
        'correct_answers' => 'integer',
        'wrong_answers' => 'integer',
        'passed' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // relasi one to one ke test, satu hasi ujian hanya ada di satu ujian le
    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    // relasi one to one ke application, satu hasil ujian hanya ada untuk satu kali aplikasi
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    // cek skor
    public function getPercentageAttribute()
    {
        if ($this->total_questions == 0) 
        {
            return 0;
        }

        return round(($this->correct_answers / $this->total_questions) * 100, 2);
    }

    // ambil nilai
    public function getGradeAttribute()
    {
        $percentage = $this->percentage;
        
        if ($percentage >= 85) return 'A';
        if ($percentage >= 70) return 'B';
        if ($percentage >= 60) return 'C';
        if ($percentage >= 50) return 'D';
        return 'E';
    }

}
