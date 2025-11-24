<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $fillable = 
    [
        'lowongan_id',
        'mahasiswa_id',
        'portofolio_url',
        'motivation_letter',
        'admin_notes',
        'status',
        'applied_at'
    ];

    protected $casts = 
    [
        'applied_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // relasi many to one, banyak aplikasi bisa ke satu lowongan
    public function lowongan() {
        return $this->belongsTo(Application::class);
    }

    // relasi many to one ke user sebagai mahasiswa
    // banyak aplikasi bisa dibuat oleh satu mahasiswa
    public function mahasiswa() {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    // relasi one to one, satu aplikasi hanya ada satu waktu pengujian (test gt sih)
    public function test() {
        return $this->hasOne(Test::class);
    }

    // relasi one to one, satu aplikasi hanya ada satu hasil ujian? yh
    public function testResult()
    {
        return $this->hasOne(TestResult::class);
    }

    // filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // filter aplikasi yang masih pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // filter aplikasi yang sudah verified
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }
}
