<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // user diizinkan untuk mengupdate profil mereka sendiri
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$userId}",
            'phone' => 'nullable|regex:/^[0-9]{10,15}$/',
            'program_studi' => 'nullable|string|max:255',
            'angkatan' => 'nullable|integer|min:2000|max:' . (date('Y') + 1),
            'ipk' => 'nullable|numeric|min:0|max:4',
            'semester' => 'nullable|integer|min:1|max:14',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'phone.regex' => 'Nomor HP harus 10-15 digit angka.',
            'ipk.min' => 'IPK minimal 0.',
            'ipk.max' => 'IPK maksimal 4.00.',
            'semester.min' => 'Semester minimal 1.',
            'semester.max' => 'Semester maksimal 14.',
        ];
    }
}
