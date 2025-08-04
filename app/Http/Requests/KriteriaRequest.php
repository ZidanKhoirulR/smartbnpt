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

        return [
            'kode' => 'required|string|max:6|unique:kriteria,kode,' . $kriteriaId,
            'kriteria' => 'required|string|max:255|unique:kriteria,kriteria,' . $kriteriaId,
            'bobot' => 'required|numeric|min:0|max:100',
            'jenis_kriteria' => 'required|in:benefit,cost',
            'ranking' => [
                'required',
                'integer',
                'min:1',
                "max:{$maxRanking}",
            ],
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
            'ranking.required' => 'Ranking kepentingan harus diisi',
            'ranking.integer' => 'Ranking harus berupa angka bulat',
            'ranking.min' => 'Ranking minimal adalah 1',
            'ranking.max' => 'Ranking tidak boleh melebihi jumlah kriteria yang ada',
            'kode.unique' => 'Kode kriteria sudah digunakan',
            'kriteria.unique' => 'Nama kriteria sudah digunakan',
            'bobot.min' => 'Bobot minimal adalah 0',
            'bobot.max' => 'Bobot maksimal adalah 100',
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
        if ($this->has('ranking')) {
            $this->merge([
                'ranking' => (int) $this->ranking,
            ]);
        }

        // Auto-cast bobot ke float
        if ($this->has('bobot')) {
            $this->merge([
                'bobot' => (float) $this->bobot,
            ]);
        }
    }
}