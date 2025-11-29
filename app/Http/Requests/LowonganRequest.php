<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LowonganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'recruiter';
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'division_id' => 'required|exists:divisions,id',
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'quota' => 'required|integer|min:1|max:100',
            'min_ipk' => 'required|numeric|between:0,4.00',
            'min_semester' => 'required|integer|between:1,14',
            'open_date' => 'required|date',
            'close_date' => 'required|date|after:open_date',
            'status' => 'required|in:draft,open,closed',
        ];

        // Untuk create, open_date harus hari ini atau setelahnya
        if ($this->isMethod('POST')) {
            $rules['open_date'] = 'required|date|after_or_equal:today';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'division_id.required' => 'Divisi wajib dipilih.',
            'division_id.exists' => 'Divisi yang dipilih tidak valid.',
            'title.required' => 'Judul lowongan wajib diisi.',
            'title.max' => 'Judul lowongan maksimal 255 karakter.',
            'location.required' => 'Lokasi wajib diisi.',
            'description.required' => 'Deskripsi lowongan wajib diisi.',
            'quota.required' => 'Kuota wajib diisi.',
            'quota.integer' => 'Kuota harus berupa angka.',
            'quota.min' => 'Kuota minimal 1.',
            'quota.max' => 'Kuota maksimal 100.',
            'min_ipk.required' => 'IPK minimum wajib diisi.',
            'min_ipk.numeric' => 'IPK minimum harus berupa angka.',
            'min_ipk.between' => 'IPK minimum harus antara 0 dan 4.00.',
            'min_semester.required' => 'Semester minimum wajib diisi.',
            'min_semester.integer' => 'Semester minimum harus berupa angka.',
            'min_semester.between' => 'Semester minimum harus antara 1 dan 14.',
            'open_date.required' => 'Tanggal buka wajib diisi.',
            'open_date.date' => 'Format tanggal buka tidak valid.',
            'open_date.after_or_equal' => 'Tanggal buka tidak boleh sebelum hari ini.',
            'close_date.required' => 'Tanggal tutup wajib diisi.',
            'close_date.date' => 'Format tanggal tutup tidak valid.',
            'close_date.after' => 'Tanggal tutup harus setelah tanggal buka.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status yang dipilih tidak valid.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'division_id' => 'divisi',
            'title' => 'judul lowongan',
            'location' => 'lokasi',
            'description' => 'deskripsi',
            'quota' => 'kuota',
            'min_ipk' => 'IPK minimum',
            'min_semester' => 'semester minimum',
            'open_date' => 'tanggal buka',
            'close_date' => 'tanggal tutup',
            'status' => 'status',
        ];
    }
}
