<?php

namespace App\Http\Requests;

use App\Models\Kriteria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KriteriaRequest extends FormRequest
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
        $kriteriaId = $this->id; // ID kriteria yang sedang diedit (null jika create)
        $totalKriteria = Kriteria::count();
        $maxRanking = $kriteriaId ? $totalKriteria : $totalKriteria + 1; // +1 untuk create baru

        $rules = [
            'kode' => [
                'required',
                'string',
                'max:6',
                Rule::unique('kriteria')->ignore($kriteriaId)
            ],
            'kriteria' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kriteria')->ignore($kriteriaId)
            ],
            // HAPUS VALIDASI BOBOT KARENA MENGGUNAKAN METODE ROC
            'jenis_kriteria' => 'required|in:benefit,cost',
        ];

        // Hanya validasi ranking untuk create, tidak untuk update
        if (!$kriteriaId) {
            $rules['ranking'] = [
                'required',
                'integer',
                'min:1',
                "max:{$maxRanking}",
                // Cek uniqueness ranking hanya untuk create
                Rule::unique('kriteria', 'ranking')
            ];
        } else {
            // Untuk edit, ranking optional dan tidak perlu unique check
            $rules['ranking'] = [
                'sometimes',
                'integer',
                'min:1',
                "max:{$maxRanking}",
            ];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'ranking.required' => 'Ranking kepentingan harus diisi',
            'ranking.integer' => 'Ranking harus berupa angka bulat',
            'ranking.min' => 'Ranking minimal adalah 1',
            'ranking.max' => 'Ranking tidak boleh melebihi jumlah kriteria yang ada',
            'ranking.unique' => 'Ranking sudah digunakan kriteria lain',
            'kode.unique' => 'Kode kriteria sudah digunakan',
            'kriteria.unique' => 'Nama kriteria sudah digunakan',
            'jenis_kriteria.required' => 'Jenis kriteria harus dipilih',
            'jenis_kriteria.in' => 'Jenis kriteria harus benefit atau cost',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Auto-cast ranking ke integer jika ada
        if ($this->has('ranking') && $this->ranking !== null) {
            $this->merge([
                'ranking' => (int) $this->ranking,
            ]);
        }

        // HAPUS AUTO-CAST BOBOT KARENA TIDAK DIGUNAKAN LAGI
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        \Log::error('Kriteria validation failed:', [
            'errors' => $validator->errors()->toArray(),
            'input' => $this->all()
        ]);

        parent::failedValidation($validator);
    }
}