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

    // lamaran buat satu lowongan
    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(Lowongan::class);
    }

    // punya satu mahasiswa
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

// ujiannya cuma satu
    public function test(): HasOne
    {
        return $this->hasOne(Test::class);
    }

    // filter status
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // nyari yg pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // nyari yg udh verified
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    // buat progress bar
    public function getProgressAttribute(): int
    {
        return match ($this->status) {
            'pending' => 15,
            'verified' => 30,
            'test' => 50,
            'interview' => 75,
            'accepted', 'rejected' => 100,
            default => 0,
        };
    }

    // label status biar kebaca
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Seleksi Dokumen',
            'test' => 'Ujian Online',
            'interview' => 'Wawancara',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            default => 'Menunggu',
        };
    }

    // warna warni status
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-blue-100 text-blue-700',
            'verified' => 'bg-orange-100 text-orange-700',
            'test' => 'bg-purple-100 text-purple-700',
            'interview' => 'bg-indigo-100 text-indigo-700',
            'accepted' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            default => 'bg-slate-100 text-slate-700',
        };
    }

    // buat timeline
    public function getTimelineAttribute(): array
    {
        $statusOrder = ['pending', 'verified', 'test', 'interview', 'accepted', 'rejected'];
        $currentIndex = array_search($this->status, $statusOrder);
        
        $steps = [
            [
                'title' => 'Pendaftaran',
                'date' => $this->created_at->format('d M'),
                'status' => 'completed',
            ],
            [
                'title' => 'Verifikasi Dokumen',
                'date' => $currentIndex >= 1 ? $this->updated_at->format('d M') : 'Menunggu',
                'status' => $currentIndex == 0 ? 'current' : ($currentIndex >= 1 ? 'completed' : 'pending'),
            ],
            [
                'title' => 'Seleksi Dokumen',
                'date' => $currentIndex >= 2 ? $this->updated_at->format('d M') : 'Menunggu',
                'status' => $currentIndex == 1 ? 'current' : ($currentIndex >= 2 ? 'completed' : 'pending'),
            ],
            [
                'title' => 'Ujian Online',
                'date' => $this->test ? $this->test->start_time?->format('d M') ?? 'Terjadwal' : 'Menunggu',
                'status' => $currentIndex == 2 ? 'current' : ($currentIndex >= 3 ? 'completed' : 'pending'),
            ],
            [
                'title' => 'Wawancara',
                'date' => $this->interview_date ? $this->interview_date->format('d M') : 'Menunggu',
                'status' => $currentIndex == 3 ? 'current' : ($currentIndex >= 4 ? 'completed' : 'pending'),
            ],
            [
                'title' => 'Pengumuman',
                'date' => in_array($this->status, ['accepted', 'rejected']) ? $this->updated_at->format('d M') : 'Menunggu',
                'status' => in_array($this->status, ['accepted', 'rejected']) ? 'completed' : 'pending',
            ],
        ];

        return $steps;
    }

    // langkah selanjutnya ngapain
    public function getNextStepAttribute(): array
    {
        if ($this->status == 'pending') {
            return [
                'message' => 'Dokumen Anda sedang dalam proses verifikasi oleh tim rekrutmen. Harap menunggu.',
                'action' => null,
            ];
        }

        if ($this->status == 'verified') {
            return [
                'message' => 'Dokumen Anda telah diverifikasi dan sedang dalam proses seleksi dokumen.',
                'action' => null,
            ];
        }

        if ($this->status == 'test') {
            if ($this->test && $this->test->scheduled_at) {
                $availability = $this->test->exam_availability;
                
                if ($availability === 'completed') {
                    return [
                        'message' => 'Ujian telah selesai. Skor: ' . ($this->test->score ?? '-') . '. Menunggu tahap selanjutnya.',
                        'action' => null,
                    ];
                }
                
                if ($availability === 'available') {
                    return [
                        'message' => 'Ujian tersedia sekarang! Kerjakan sebelum waktu habis.',
                        'action' => 'Mulai Ujian',
                        'url' => route('student.exam.start', $this->test->id),
                    ];
                }
                
                if ($availability === 'waiting') {
                    return [
                        'message' => 'Ujian dijadwalkan pada ' . $this->test->schedule_info . '. ' . $this->test->time_until_schedule . '.',
                        'action' => null,
                    ];
                }
                
                if ($availability === 'expired') {
                    return [
                        'message' => 'Waktu ujian telah berakhir. Hubungi rekruter untuk informasi lebih lanjut.',
                        'action' => null,
                    ];
                }
            }
            return [
                'message' => 'Menunggu jadwal ujian online dari rekruter.',
                'action' => null,
            ];
        }

        if ($this->status == 'interview') {
            return [
                'message' => 'Jadwal Wawancara: ' . ($this->interview_date ? $this->interview_date->format('d M Y, H:i') : 'Menunggu Jadwal') . '. Lokasi: ' . ($this->interview_location ?? 'Akan diinformasikan'),
                'action' => null,
            ];
        }

        if ($this->status == 'accepted') {
            return [
                'message' => 'Selamat! Anda diterima sebagai Asisten Laboratorium. Silakan hubungi koordinator lab untuk informasi lebih lanjut.',
                'action' => null,
            ];
        }

        if ($this->status == 'rejected') {
            return [
                'message' => 'Mohon maaf, Anda belum lolos seleksi tahap ini. Jangan menyerah, coba lagi di kesempatan berikutnya!',
                'action' => null,
            ];
        }

        return [
            'message' => 'Menunggu update selanjutnya dari tim rekrutmen.',
            'action' => null,
        ];
    }

    /**
     * info jadwal ujian
     */
    public function getExamScheduleLabelAttribute(): ?string
    {
        if ($this->status !== 'test' || !$this->test || !$this->test->scheduled_at) {
            return null;
        }
        
        $scheduled = $this->test->scheduled_at;
        $duration = $this->test->duration_minutes;
        
        return "Dijadwalkan: " . $scheduled->translatedFormat('d F Y, H:i') . " WIB | Durasi: {$duration} menit";
    }

    /**
     * status ujiannya
     */
    public function getExamStatusAttribute(): ?string
    {
        if ($this->status !== 'test' || !$this->test) {
            return null;
        }
        
        return $this->test->exam_availability;
    }

    /**
     * label status ujian
     */
    public function getExamStatusLabelAttribute(): ?string
    {
        $status = $this->exam_status;
        
        if (!$status) {
            return null;
        }

        return match ($status) {
            'waiting' => 'Tersisa ' . $this->test->time_until_schedule,
            'available' => 'Ujian tersedia - Mulai sekarang!',
            'completed' => 'Ujian selesai - Skor: ' . ($this->test->score ?? '-'),
            'expired' => 'Waktu ujian terlewat',
            default => null,
        };
    }

    /**
     * warna status ujian
     */
    public function getExamStatusColorAttribute(): ?string
    {
        $status = $this->exam_status;
        
        if (!$status) {
            return null;
        }

        return match ($status) {
            'waiting' => 'text-orange-600',
            'available' => 'text-green-600',
            'completed' => 'text-blue-600',
            'expired' => 'text-red-600',
            default => 'text-slate-600',
        };
    }
}
