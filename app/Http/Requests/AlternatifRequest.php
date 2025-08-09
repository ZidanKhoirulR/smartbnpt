<?php
// File: app/Http/Requests/AlternatifRequest.php
// VERSION: CLEAN - Tetap validasi NIK untuk admin internal

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlternatifRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode' => 'required|string|max:6|unique:alternatif,kode,' . $this->id,
            'nik' => 'required|string|size:16|regex:/^[0-9]+$/|unique:alternatif,nik,' . $this->id,
            'alternatif' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nik.required' => 'NIK harus diisi',
            'nik.size' => 'NIK harus terdiri dari 16 digit',
            'nik.regex' => 'NIK hanya boleh berisi angka',
            'nik.unique' => 'NIK sudah terdaftar dalam sistem',
            'kode.required' => 'Kode alternatif harus diisi',
            'kode.unique' => 'Kode alternatif sudah digunakan',
            'alternatif.required' => 'Nama alternatif harus diisi',
            'alternatif.max' => 'Nama alternatif maksimal 255 karakter',
            'keterangan.max' => 'Keterangan maksimal 1000 karakter',
        ];
    }
}