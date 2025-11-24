<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBank extends Model
{
    use HasFactory;

    protected $table = 'question_banks';

    protected $fillable = 
    [
        'division_id',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'points',
        'is_active',
    ];

    protected $casts = [
        'points' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // relasi many to one, banyak soal bisa dimiliki satu divisi
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // relasi one to many, satu soal bias dijawab banyak kali sama mahasiswa beda-beda
    public function testAnswers()
    {
        return $this->hasMany(TestAnswer::class, 'question_id');
    }

    // filter soal aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // filter soal berdasarkan divisi
    public function scopeForDivision($query, $divisionId)
    {
        return $query->where('division_id', $divisionId);
    }

    // function helper
    public function getOptionsAttribute()
    {
        return [
            'a' => $this->option_a,
            'b' => $this->option_b,
            'c' => $this->option_c,
            'd' => $this->option_d,
        ];
    } 
}
