<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class QuestionBank extends Model
{
    use HasFactory;
    protected $table = 'question_banks';
    protected $fillable = [
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

    protected function casts(): array
    {
        return [
            'points' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    // relasi many to one, banyak soal bisa dimiliki satu divisi
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    // relasi one to many, satu soal bisa dijawab banyak kali oleh mahasiswa berbeda
    public function testAnswers(): HasMany
    {
        return $this->hasMany(TestAnswer::class, 'question_id');
    }


    // scoping untuk memfilter soal yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // scoping untuk memfilter soal berdasarkan divisi
    public function scopeForDivision($query, int $divisionId)
    {
        return $query->where('division_id', $divisionId);
    }

    // helper untuk mendapatkan semua pilihan jawaban dalam bentuk array
    protected function options(): Attribute
    {
        return Attribute::get(fn () => [
            'a' => $this->option_a,
            'b' => $this->option_b,
            'c' => $this->option_c,
            'd' => $this->option_d,
        ]);
    }
}
