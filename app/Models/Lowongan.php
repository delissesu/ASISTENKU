<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongans';

    protected $fillable = 
    [
        'division_id',
        'recruiter_id',
        'title',
        'description',
        'quota',
        'min_ipk',
        'min_semester',
        'open_date',
        'close_date',
        'status',
    ];

    protected $casts = 
    [
        'quota' => 'integer',
        'min_ipk' => 'float',
        'min_semester' => 'integer',
        'open_date' => 'date',
        'close_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // relasi many to one, banyak lowongan dimiliki satu divisi
    public function division() {
        return $this->belongsTo(Division::class);
    }
    
    // relasi many to one, banyak lowongan dibuat oleh satu recruiter
    public function recruiter() {
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    // satu lowongan punya banyak pendaftaran
    public function applications() {
        return $this->hasMany(Application::class);
    }
    
    // scoping untuk filter lowongan yang sedang dibuka
    public function scopeOpen($query)
    {
        return $query->where('status', 'open')
                     ->where('open_date', '<=', now())
                     ->where('close_date', '>=', now());
    }

    // scoping untuk filter status yang buka ajah
    public function scopeByStatus($query, $status) 
    {
        return $query->where('status', $status);
    }

    // helper function
    // cek lowongan
    public function isOpen()
    {
        return $this->status === 'open' 
            && $this->open_date <= now() 
            && $this->close_date >= now();
    }

    // cek sisa kuota lowongan pendaftaran
    public function getRemainingQuotaAttribute()
    {
        $accepted = $this->applications()->where('status', 'accepted')->count();
        return $this->quota - $accepted;
    }


}
