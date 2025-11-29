<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $fillable = [
        'lowongan_id',
        'mahasiswa_id',
        'portofolio_url',
        'motivation_letter',
        'admin_notes',
        'status',
        'applied_at',
        'interview_date',
        'interview_location',
        'interview_notes'
    ];

    protected function casts(): array
    {
        return [
            'applied_at' => 'datetime',
            'interview_date' => 'datetime',
        ];
    }

    // banyak lamaran buat satu lowongan
    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(Lowongan::class);
    }

    // banyak lamaran dari satu mahasiswa
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    // satu lamaran cuma satu ujian
    public function test(): HasOne
    {
        return $this->hasOne(Test::class);
    }

    // filter lamaran pake status
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // filter yang masih pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // filter yang udah diverifikasi
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    // Accessor untuk progress bar (return int 0-100)
    public function getProgressAttribute(): int
    {
        return match ($this->status) {
            'pending' => 20,
            'verified' => 50,
            'interview' => 75,
            'accepted', 'rejected' => 100,
            default => 0,
        };
    }

    // Accessor untuk label status yang user-friendly
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Seleksi Berkas',
            'verified' => 'Wawancara',
            'interview' => 'Menunggu Hasil',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            default => 'Menunggu',
        };
    }

    // Accessor untuk warna badge status
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-blue-100 text-blue-700',
            'verified' => 'bg-orange-100 text-orange-700',
            'interview' => 'bg-purple-100 text-purple-700',
            'accepted' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            default => 'bg-slate-100 text-slate-700',
        };
    }

    // Accessor untuk Timeline Seleksi
    public function getTimelineAttribute(): array
    {
        $steps = [
            [
                'title' => 'Pendaftaran',
                'date' => $this->created_at->format('d M'),
                'status' => 'completed', // Selalu completed kalo udah ada recordnya
            ],
            [
                'title' => 'Verifikasi Dokumen',
                'date' => $this->status == 'pending' ? 'Sedang Diproses' : ($this->updated_at->format('d M')),
                'status' => $this->status == 'pending' ? 'current' : 'completed',
            ],
            [
                'title' => 'Ujian Online',
                'date' => $this->test ? $this->test->start_time->format('d M') : 'TBA',
                'status' => $this->test ? ($this->test->status == 'completed' ? 'completed' : 'current') : 'pending',
            ],
            [
                'title' => 'Wawancara',
                'date' => $this->interview_date ? $this->interview_date->format('d M') : 'TBA',
                'status' => $this->status == 'interview' ? 'current' : (in_array($this->status, ['accepted', 'rejected']) ? 'completed' : 'pending'),
            ],
            [
                'title' => 'Pengumuman',
                'date' => in_array($this->status, ['accepted', 'rejected']) ? $this->updated_at->format('d M') : 'TBA',
                'status' => in_array($this->status, ['accepted', 'rejected']) ? 'completed' : 'pending',
            ],
        ];

        return $steps;
    }

    // Accessor untuk Langkah Selanjutnya (Next Step Box)
    public function getNextStepAttribute(): array
    {
        if ($this->status == 'pending') {
            return [
                'message' => 'Dokumen Anda sedang dalam proses verifikasi oleh tim rekrutmen.',
                'action' => null,
            ];
        }

        if ($this->status == 'verified') {
            if ($this->test && $this->test->status != 'completed') {
                return [
                    'message' => 'Silakan ikuti ujian online sebelum ' . $this->test->end_time->format('d M H:i') . '.',
                    'action' => 'Mulai Ujian',
                    'url' => route('student.exam'), // Asumsi route exam
                ];
            }
            return [
                'message' => 'Menunggu jadwal ujian online atau wawancara.',
                'action' => null,
            ];
        }

        if ($this->status == 'interview') {
            return [
                'message' => 'Jadwal Wawancara: ' . ($this->interview_date ? $this->interview_date->format('d M Y, H:i') : 'Menunggu Jadwal') . '. Lokasi: ' . ($this->interview_location ?? 'Online'),
                'action' => null,
            ];
        }

        if ($this->status == 'accepted') {
            return [
                'message' => 'Selamat! Anda diterima. Silakan hubungi koordinator lab untuk informasi lebih lanjut.',
                'action' => null,
            ];
        }

        if ($this->status == 'rejected') {
            return [
                'message' => 'Mohon maaf, Anda belum lolos seleksi tahap ini. Tetap semangat!',
                'action' => null,
            ];
        }

        return [
            'message' => 'Menunggu update selanjutnya.',
            'action' => null,
        ];
    }
}
