<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only mahasiswa can apply
        return $this->user() && $this->user()->role === 'mahasiswa';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lowongan_id' => 'required|exists:lowongans,id',
            'motivation_letter' => 'required|string|min:100|max:1000',
            'portofolio_url' => 'nullable|url|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
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
