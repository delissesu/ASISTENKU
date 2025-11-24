<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class Test extends Model
{
    use HasFactory;

    protected $table = 'tests';

    protected $fillable = 
    [
        'application_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'status',   
    ];

    protected $casts = 
    [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'duration_minutes' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // relasi one to one, satu ujian hanya untuk satu apply
    public function application() {
        return $this->belongsTo(Application::class);
    }

    // relasi one to many, satu tes bisa ada banyak jawaban, kan?
    public function testAnswers() 
    {
        return $this->hasMany(TestAnswer::class);
    }

    // relasi one to one, satu tes haruse ada satu result doang
    public function testResult()
    {
        return $this->hasOne(TestResult::class);
    }

    // filter tes yang masih berlangsung
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    // filter yang sudah selesai ngerjain
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // function helper
    // cek expired
    public function isExpired() 
    {
        return now()->greaterThan($this->end_time);
    }

    // cek waktu tersisa
    public function getRemainingTimeAttribute()
    {
        if ($this->status !== 'in_progress')
        {
            return 0;
        }
        $remaining = now()->diffInMinutes($this->end_time, false);
        return max(0, $remaining);
    }
}
