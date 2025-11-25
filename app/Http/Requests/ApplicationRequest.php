<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        // hanya user dengan role mahasiswa yang boleh melamar
        return $this->user() && $this->user()->role === 'mahasiswa';
    }

    public function rules(): array
    {
        return [
            'lowongan_id' => 'required|exists:lowongans,id',
            'motivation_letter' => 'required|string|min:100|max:1000',
            'portofolio_url' => 'nullable|url|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'lowongan_id.required' => 'Lowongan harus dipilih.',
            'lowongan_id.exists' => 'Lowongan tidak ditemukan.',
            'motivation_letter.required' => 'Surat motivasi wajib diisi.',
            'motivation_letter.min' => 'Surat motivasi minimal 100 karakter.',
            'motivation_letter.max' => 'Surat motivasi maksimal 1000 karakter.',
            'portofolio_url.url' => 'URL portofolio tidak valid.',
        ];
    }
}
