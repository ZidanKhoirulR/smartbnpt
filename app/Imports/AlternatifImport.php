<?php

namespace App\Imports;

use App\Models\Alternatif;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AlternatifImport implements ToModel, WithStartRow, WithHeadingRow, WithValidation
{
    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function model(array $row)
    {
        $lastKode = Alternatif::orderBy('kode', 'desc')->first();
        if ($lastKode) {
            $kode = "A" . str_pad((int) substr($lastKode->kode, 1) + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $kode = "A00001";
        }

        return new Alternatif([
            'kode' => $kode,
            'nik' => $row['nik'] ?? null,
            'alternatif' => $row['alternatif'],
            'keterangan' => $row['keterangan'] ?? null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    public function rules(): array
    {
        return [
            'nik' => 'required|string|size:16|regex:/^[0-9]+$/|unique:alternatif,nik',
            'alternatif' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.required' => 'NIK harus diisi',
            'nik.size' => 'NIK harus terdiri dari 16 digit',
            'nik.regex' => 'NIK hanya boleh berisi angka',
            'nik.unique' => 'NIK sudah terdaftar dalam sistem',
        ];
    }
}