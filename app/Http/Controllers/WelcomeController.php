<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function searchNik(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16|regex:/^[0-9]+$/'
        ], [
            'nik.required' => 'NIK harus diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.regex' => 'NIK hanya boleh berisi angka'
        ]);

        $dashboardController = new DashboardController();
        $result = $dashboardController->searchByNik($request->nik);

        if (!$result) {
            return back()->with('error', 'NIK tidak ditemukan dalam database.');
        }

        return back()->with([
            'success' => 'Data ditemukan!',
            'result' => $result
        ]);
    }
}