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
                // Validasi unique ranking (kecuali untuk record yang sedang diedit)
                Rule::unique('kriteria', 'ranking')->ignore($kriteriaId),
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
            'ranking.unique' => 'Ranking ini sudah digunakan oleh kriteria lain',
            'kode.unique' => 'Kode kriteria sudah digunakan',
            'kriteria.unique' => 'Nama kriteria sudah digunakan',
            'bobot.min' => 'Bobot minimal adalah 0',
            'bobot.max' => 'Bobot maksimal adalah 100',
            'jenis_kriteria.required' => 'Jenis kriteria harus dipilih',
            'jenis_kriteria.in' => 'Jenis kriteria harus benefit atau cost',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validasi tambahan: pastikan ranking berurutan
            $this->validateRankingSequence($validator);
        });
    }

    /**
     * Validasi bahwa ranking tidak memiliki gap yang terlalu besar
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    protected function validateRankingSequence($validator)
    {
        $kriteriaId = $this->id;
        $newRanking = $this->ranking;

        // Ambil semua ranking yang ada (kecuali yang sedang diedit)
        $existingRankings = Kriteria::when($kriteriaId, function ($query) use ($kriteriaId) {
            return $query->where('id', '!=', $kriteriaId);
        })->pluck('ranking')->filter()->sort()->values()->toArray();

        // Jika ini adalah create dan ranking sudah ada
        if (!$kriteriaId && in_array($newRanking, $existingRankings)) {
            $validator->errors()->add('ranking', 'Ranking ini sudah digunakan oleh kriteria lain');
            return;
        }

        // Simulasi ranking setelah insert/update
        $allRankings = collect($existingRankings)->push($newRanking)->sort()->values()->toArray();

        // Periksa apakah ada gap yang tidak wajar (lebih dari 1)
        for ($i = 1; $i < count($allRankings); $i++) {
            if ($allRankings[$i] - $allRankings[$i - 1] > 1) {
                $validator->errors()->add(
                    'ranking',
                    'Ranking akan menyebabkan gap dalam urutan. Harap gunakan ranking yang berurutan.'
                );
                break;
            }
        }

        // Periksa apakah ranking pertama dimulai dari 1
        if (!empty($allRankings) && $allRankings[0] != 1) {
            $validator->errors()->add('ranking', 'Ranking harus dimulai dari 1 dan berurutan');
        }
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