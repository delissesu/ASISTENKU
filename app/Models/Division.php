<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'divisions';

    // pk id default, tp eksplisit aja
    protected $primaryKey = 'id';

    // bisa diisi
    protected $fillable = 
    [
        'name',
        'slug',
        'description',
        'requirements',
        'is_active'
    ];

    // casting
    protected $casts = 
    [
        'is_active' => 'boolean',
        'created_at' => 'datettime',
        'updated_at' => 'datettime',
    ];

    // relasi satu divisi bisa punya banyak lowongan
    public function lowongans() {
        return $this->hasMany(Lowongan::class);
    }

    // relasi satu divisi bisa punya banyak pertanyaan
    public function questionBanks() {
        return $this->hasMany(QuestionBank::class);
    }
}
