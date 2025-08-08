<?php

namespace App\Http\Requests;

use App\Models\SubKriteria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubKriteriaRequest extends FormRequest
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
        $subKriteriaId = $this->id; // ID untuk update
        $kriteriaId = $this->kriteria_id;

        return [
            'sub_kriteria' => [
                'required',
                'string',
                'max:255',
                // Unique dalam scope kriteria yang sama, kecuali record yang sedang diedit
                Rule::unique('sub_kriteria', 'sub_kriteria')
                    ->where('kriteria_id', $kriteriaId)
                    ->ignore($subKriteriaId)
            ],
            'bobot' => 'required|numeric|min:0|max:999.99',
            'kriteria_id' => 'required|integer|exists:kriteria,id',
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
            'sub_kriteria.required' => 'Nama sub kriteria harus diisi',
            'sub_kriteria.unique' => 'Sub kriteria sudah ada dalam kriteria ini',
            'bobot.required' => 'Bobot harus diisi',
            'bobot.numeric' => 'Bobot harus berupa angka',
            'bobot.min' => 'Bobot minimal adalah 0',
            'bobot.max' => 'Bobot maksimal adalah 999.99',
            'kriteria_id.required' => 'Kriteria harus dipilih',
            'kriteria_id.exists' => 'Kriteria tidak valid',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Pastikan bobot dalam format decimal yang benar
        if ($this->has('bobot')) {
            $this->merge([
                'bobot' => (float) str_replace(',', '.', $this->bobot)
            ]);
        }

        // Pastikan kriteria_id dalam format integer
        if ($this->has('kriteria_id')) {
            $this->merge([
                'kriteria_id' => (int) $this->kriteria_id
            ]);
        }
    }
}