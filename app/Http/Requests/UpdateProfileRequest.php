<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'ipk' => 'nullable|numeric|min:0|max:4',
            'semester' => 'nullable|integer|min:1|max:14',
            'skills' => 'nullable|string',
            'cv' => 'nullable|file|mimes:pdf|max:2048',
            'transkrip' => 'nullable|file|mimes:pdf|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'ipk.numeric' => 'IPK harus berupa angka.',
            'ipk.min' => 'IPK minimal 0.',
            'ipk.max' => 'IPK maksimal 4.',
            'semester.integer' => 'Semester harus berupa angka.',
            'semester.min' => 'Semester minimal 1.',
            'semester.max' => 'Semester maksimal 14.',
            'cv.mimes' => 'CV harus berupa file PDF.',
            'cv.max' => 'Ukuran CV maksimal 2MB.',
            'transkrip.mimes' => 'Transkrip harus berupa file PDF.',
            'transkrip.max' => 'Ukuran transkrip maksimal 2MB.',
        ];
    }
}
