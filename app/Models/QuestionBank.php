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

    // banyak soal di satu divisi
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    // satu soal dijawab banyak mahasiswa
    public function testAnswers(): HasMany
    {
        return $this->hasMany(TestAnswer::class, 'question_id');
    }


    // filter soal aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // filter soal per divisi
    public function scopeForDivision($query, int $divisionId)
    {
        return $query->where('division_id', $divisionId);
    }

    // ambil semua opsi jawaban
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
